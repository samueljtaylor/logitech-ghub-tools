<?php

namespace App\Contracts\Collections;

use Illuminate\Support\Collection;

interface CollectionContract
{
    /**
     * New instance from JSON.
     *
     * @param string $json
     * @return static
     */
    public static function newFromJson(string $json): static;

    /**
     * New instance from array.
     *
     * @param array $array
     * @return static
     */
    public static function newFromArray(array $array): static;

    /**
     * New instance from existing Collection.
     *
     * @param Collection $collection
     * @return static
     */
    public static function newFromCollection(Collection $collection): static;
}
