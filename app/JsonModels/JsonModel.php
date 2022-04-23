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
use Illuminate\Support\Enumerable;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JsonSerializable;
use phpDocumentor\Reflection\Types\Iterable_;

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

    public function __construct(iterable $attributes = [])
    {
        $this->timestamps = false;
        $this->fill($attributes);
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
        $models = new Collection();

        foreach($this->extractModelData($this->repository()->collection()) as $model) {
            $models->push(new static($model));
        }

        return $models;
    }

    /**
     * Get the model specific data from the entire collection.
     *
     * @param Collection $collection
     * @return Collection
     */
    protected function extractModelData(Collection $collection): Collection
    {
        $key = $this->getModelKey();
        return $this->doubleNested ? $collection->$key->$key : $collection->$key;
    }

    /**
     * @inheritDoc
     */
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

    /**
     * @inheritDoc
     */
    public function update(array $attributes): void
    {
        $this->fill($attributes);
        $this->save();
    }

    /**
     * @inheritDoc
     */
    public function save(): void
    {
        // In order to save the data to the JSON file we need to make a copy of the collection
        // and use that collection to update only the specific model attributes we want to change,
        // then return the entire collection to the FileRepository and save it.
        // We can then use that file to compare to the actual database and then write all the
        // changes to the actual database at once rather than in multiple steps.
        $newCollection = $this->repository()->collection();
        $model = $this->extractModelData($newCollection)->where('id', $this->getAttribute('id'))->first();

        foreach($this->attributes as $key => $value) {
            $model->put($key, $value);
        }

        $this->repository()->setCollection($newCollection)->save();
    }

    /**
     * @inheritDoc
     */
    public static function create(array $attributes): static
    {
        $card = new static($attributes);
        $card->save();
        return $card;
    }

    /**
     * @inheritDoc
     */
    public function fill(iterable $attributes = []): void
    {
        foreach($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }
}
