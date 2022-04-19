<?php

namespace App\JsonModels;

use App\Contracts\JsonFileRepositoryContract;
use App\Contracts\JsonModelContract;
use ErrorException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Repositories\JsonFileRepository;

abstract class JsonModel implements JsonModelContract
{
    /**
     * The model's key on the stored data.
     *
     * @var string
     */
    protected string $modelKey;

    /**
     * Is the model data nested in itself?
     *
     * 'model' => [
     *      'model' => [
     *          ...
     *      ]
     * ]
     *
     * @var bool
     */
    protected bool $doubleNested = true;

    /**
     * Fields on this model.
     *
     * @var array
     */
    protected array $fields = [];

    /**
     * The actual attributes.
     *
     * @var array
     */
    protected array $attributes;

    /**
     * Model attributes that should be read only.
     *
     * @var array
     */
    protected array $readOnlyAttributes = ['id'];

    /**
     * The repository.
     *
     * @var JsonFileRepository
     */
    protected JsonFileRepository $repository;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        if(!isset($this->modelKey)) {
            $this->modelKey = $this->guessModelKey();
        }
    }

    /**
     * Guess the modelKey if not set.
     *
     * @return string
     */
    protected function guessModelKey(): string
    {
        return Str::plural(Str::camel(class_basename($this)));
    }

    /**
     * @inheritDoc
     */
    public function fill(array $attributes): void
    {
        foreach($this->fields as $field) {
            if(array_key_exists($field, $attributes)) {
                $this->attributes[$field] = $attributes[$field];
            }
        }
    }

    /**
     * Get the raw attribute value.
     *
     * @param string $field
     * @return mixed
     */
    public function getRawAttribute(string $field): mixed
    {
        try {
            return $this->attributes[$field];
        } catch (ErrorException) {
            return null;
        }

    }

    /**
     * Set the raw attribute value.
     *
     * @param string $field
     * @param mixed $value
     * @return void
     */
    public function setRawAttribute(string $field, mixed $value): void
    {
        $this->attributes[$field] = $value;
    }

    /**
     * @inheritDoc
     */
    public function getAttribute(string $field): mixed
    {
        if(method_exists($this, $field)) {
            $callable = $this->$field()->get;
            return $callable($this->getRawAttribute($field));
        }
        return $this->getRawAttribute($field);
    }

    /**
     * @inheritDoc
     */
    public function setAttribute(string $field, mixed $value): void
    {
        if(method_exists($this, $field)) {
            $callable = $this->$field()->set;
            $this->setRawAttribute($field, $callable($value));
        } else {
            $this->setRawAttribute($field, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function save(): void
    {
        $storedData = $this->modelData()->where('id', $this->getAttribute('id'))->first();
        foreach($this->attributes as $key => $value) {
            $storedData->put($key, $value);
        }
        $this->repository()->save();
    }

    /**
     * Alias to get an attribute.
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->getAttribute($name);
    }

    /**
     * @inheritDoc
     */
    public function repository(): JsonFileRepositoryContract
    {
        $this->repository ??= JsonFileRepository::instance();
        return $this->repository;
    }

    /**
     * @inheritDoc
     */
    public function storedData(): Collection
    {
        return $this->repository()->settings()->collection();
    }

    /**
     * @inheritDoc
     */
    public function modelData(): Collection
    {
        $data = $this->storedData()->get($this->modelKey);

        if($this->doubleNested) {
            $data = $data->get($this->modelKey);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function findById(string $id): static
    {
        $this->fill($this->modelData()->where('id', $id)->first()->toArray());
        return $this;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * @inheritDoc
     */
    public static function instance(): static
    {
        return new static;
    }

    /**
     * @inheritDoc
     */
    public static function all(): Collection
    {
        return static::instance()->modelData();
    }

    /**
     * @inheritDoc
     */
    public static function where(string $key, mixed $operator, mixed $value = null): Collection
    {
        return static::instance()->modelData()->where($key, $operator, $value);
    }

    /**
     * @inheritDoc
     */
    public static function find(string $id): static
    {
        return static::instance()->findById($id);
    }


}
