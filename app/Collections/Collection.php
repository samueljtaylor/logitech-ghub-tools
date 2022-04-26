<?php

namespace App\Collections;

use App\Contracts\Collections\CollectionContract;
use \Illuminate\Support\Collection as LaravelCollection;

class Collection extends LaravelCollection implements CollectionContract
{
    /**
     * @inheritDoc
     */
    public static function newFromJson(string $json): static
    {
        return static::newFromArray(json_decode($json, true));
    }

    /**
     * @inheritDoc
     */
    public static function newFromArray(array $array): static
    {
        return static::newFromCollection(new static($array));
    }

    /**
     * @inheritDoc
     */
    public static function newFromCollection(LaravelCollection $collection): static
    {
        return (new static($collection))->recursive(static::class);
    }

    /**
     * Override __get to alias the get() method.
     *
     * @param mixed $key
     * @return mixed
     */
    public function __get(mixed $key): mixed
    {
        return $this->$key ?? $this->get($key);
    }

    /**
     * @inheritDoc
     */
    public function find(mixed $value, string $field = 'id'): mixed
    {
        return $this->where($field, $value)->first();
    }
}
