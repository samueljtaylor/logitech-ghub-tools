<?php

namespace App\Collections;

use App\Contracts\Collections\SettingsCollection as SettingsCollectionContract;
use Illuminate\Support\Collection;

class SettingsCollection extends Collection implements SettingsCollectionContract
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
        return static::newFromCollection(new Collection($array));
    }

    /**
     * @inheritDoc
     */
    public static function newFromCollection(Collection $collection): static
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
}
