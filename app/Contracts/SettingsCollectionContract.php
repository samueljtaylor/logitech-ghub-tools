<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface SettingsCollectionContract
{
    /**
     * New instance from JSON.
     *
     * @param string $json
     * @return $this
     */
    public static function newFromJson(string $json): static;

    /**
     * New instance from an array.
     *
     * @param array $array
     * @return $this
     */
    public static function newFromArray(array $array): static;

    /**
     * New instance from an exiting Collection.
     *
     * @param Collection $collection
     * @return $this
     */
    public static function newFromCollection(Collection $collection): static;

    /**
     * New instance and load data from database.
     *
     * @return $this
     */
    public static function newFromDatabase(): static;

    /**
     * Get the collection.
     *
     * @return Collection
     */
    public function collection(): Collection;

    /**
     * Write this collection to the database.
     *
     * @return bool
     */
    public function writeToDatabase(): bool;

    /**
     * Set the collection.
     *
     * @param Collection $collection
     * @return void
     */
    public function setCollection(Collection $collection): void;

    /**
     * Forward method call to the Collection object.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function forwardMethodCall(string $name, array $arguments = []): mixed;

    /**
     * Handle calls to Collection object.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments = []): mixed;

    /**
     * Handle static calls to Collection object.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments): mixed;

    /**
     * Compare this collection to another and determine if they are the same.
     *
     * @param SettingsCollectionContract $settingsCollection
     * @return bool
     */
    public function isSameAs(SettingsCollectionContract $settingsCollection): bool;

    /**
     * Get the data as JSON.
     *
     * @return string
     */
    public function json(): string;
}
