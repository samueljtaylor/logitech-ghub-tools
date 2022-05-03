<?php

namespace App\JsonModels;

use App\Collections\SettingsCollection;
use App\Contracts\JsonModels\HasDefaultValues;
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
use App\Collections\Collection;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JsonSerializable;

abstract class JsonModel implements JsonModelContract,
    Arrayable,
    ArrayAccess,
    CanBeEscapedWhenCastToString,
    Jsonable,
    JsonSerializable,
    UrlRoutable,
    HasDefaultValues
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
        return $this->$name ?? $this->getAttribute($name) ?? $this->newQuery()->$name;
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
        return (new static)->$name(...$arguments);
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
        return $this->getPrimaryKey();
    }

    /**
     * @inheritDoc
     */
    public function resolveRouteBinding($value, $field = null): static
    {
        return $this->newQuery()->find($value, $field ?? $this->getRouteKeyName());
    }

    /**
     * @inheritDoc
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }

    /**
     * Get the primary key field name.
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey ?? 'id';
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
        $modelData = $this->extractModelData($newCollection);

        try {
            // This will handle updates
            $model = $modelData->where('id', $this->getAttribute('id'))->firstOrFail();

            foreach($this->attributes as $key => $value) {
                $model->put($key, $value);
            }
        } catch (ItemNotFoundException) {
            // This will handle inserts
            $modelData->push([...$this->attributes]);
        }

        $this->repository()->setCollection($newCollection)->save();
    }

    /**
     * @inheritDoc
     */
    public function delete(): void
    {
        // Because we're using a large collection, we're going to need to effectively rebuild the
        // collection without the deleted model. This is similar to the save() method, but we need
        // to use the reject method which will always return a new collection instance. First things
        // first we're going to extract the model data and remove the model.
        $modelData = $this->extractModelData($this->repository()->collection())->reject(function ($item) {
            return $item->get('id') === $this->getAttribute('id');
        });

        if($this->doubleNested) {
            $keyedData = SettingsCollection::newFromArray([$this->getModelKey() => $modelData]);
        } else {
            $keyedData = SettingsCollection::newFromCollection($modelData);
        }

        // Now we're going to go through the original collection and just remove this model's entire data
        // and put the new data we created above in its place.
        $newCollection = $this->repository()->collection()->reject(fn ($item, $key) => $key === $this->getModelKey());
        $newCollection->put($this->getModelKey(), $keyedData);

        // We'll send the new collection to the file repository and re-sort the keys.
        $this->repository()->setCollection($newCollection->sortKeys())->save();
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
    public static function createFromJson(string $json): static
    {
        return static::create(json_decode($json, true));
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

    /**
     * @inheritDoc
     */
    public static function newWithDefaults(array $attributes = []): static
    {
        return new static(array_merge(static::getDefaultValues(), $attributes));
    }

    /**
     * @inheritDoc
     */
    public static function getDefaultValues(): array
    {
        return [];
    }


}
