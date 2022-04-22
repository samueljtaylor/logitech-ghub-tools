<?php

namespace App\JsonModels;

use App\Contracts\JsonModels\JsonModel as JsonModelContract;
use App\Repositories\FileRepository;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\CanBeEscapedWhenCastToString;
use Illuminate\Contracts\Support\Jsonable;
use ArrayAccess;
use Illuminate\Database\Eloquent\Concerns\GuardsAttributes;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Concerns\HasGlobalScopes;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Concerns\HidesAttributes;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JsonSerializable;

abstract class JsonModel implements JsonModelContract, Arrayable, ArrayAccess, CanBeEscapedWhenCastToString, Jsonable, JsonSerializable, UrlRoutable
{
    use HasAttributes;
    use HasEvents;
    use HasGlobalScopes;
    use HasRelationships;
    use HidesAttributes;
    use GuardsAttributes;
    use ForwardsCalls;
    use HasTimestamps;

    /**
     * @var bool
     */
    protected bool $escapeWhenCastingToString = true;

    /**
     * @var bool
     */
    protected bool $doubleNested = true;

    /**
     * @var string
     */
    protected string $modelKey;

    /**
     * @var string
     */
    protected string $primaryKey;

    public function __construct($attributes = [])
    {
        $this->timestamps = false;

        foreach($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Get whether items are incremented.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge($this->attributesToArray(), $this->relationsToArray());
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return ! is_null($this->getAttribute($offset));
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->getAttribute($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset], $this->relations[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function escapeWhenCastingToString($escape = true): static
    {
        $this->escapeWhenCastingToString = $escape;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0): string
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @inheritDoc
     */
    public static function all(): Collection
    {
        return static::query();
    }

    /**
     * @inheritDoc
     */
    public static function query(): Collection
    {
        return (new static)->newQuery();
    }

    /**
     * @inheritDoc
     */
    public function newQuery(): Collection
    {
        $modelCollection = $this->repository()->get($this->getModelKey());
        $models = new Collection();

        if($this->doubleNested) {
            $modelCollection = $modelCollection->get($this->getModelKey());
        }

        foreach($modelCollection as $modelData) {
            $models->push(new static($modelData));
        }

        return $models;
    }

    public function repository(): FileRepository
    {
        return new FileRepository();
    }

    /**
     * @inheritDoc
     */
    public function getModelKey(): string
    {
        return $this->modelKey ?? $this->guessModelKey();
    }

    /**
     * @inheritDoc
     */
    public function guessModelKey(): string
    {
        return Str::plural(Str::camel(class_basename($this)));
    }


    /**
     * Forward __get calls to collection object if property doesn't exist.
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }

        return $this->newQuery()->$name;
    }

    /**
     * Forward calls to the FileRepository.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->forwardCallTo($this->newQuery(), $name, $arguments);
    }

    /**
     * Forward calls to the FileRepository.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return (new static)->$name($arguments);
    }

    /**
     * @inheritDoc
     */
    public function getRouteKey(): mixed
    {
        return $this->getAttribute($this->getRouteKeyName());
    }

    /**
     * @inheritDoc
     */
    public function getRouteKeyName(): string
    {
        return $this->primaryKey ?? 'id';
    }

    /**
     * @inheritDoc
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->newQuery()->where($field ?? $this->getRouteKeyName(), $value)->first();
    }

    /**
     * @inheritDoc
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
