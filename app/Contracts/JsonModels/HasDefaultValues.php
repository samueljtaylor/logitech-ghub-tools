<?php

namespace App\Contracts\JsonModels;

interface HasDefaultValues
{
    /**
     * Make a new instance with default values.
     *
     * @param array $attributes
     * @return static
     */
    public static function newWithDefaults(array $attributes = []): static;

    /**
     * Get the default structure and values.
     *
     * @return array
     */
    public static function getDefaultValues(): array;
}
