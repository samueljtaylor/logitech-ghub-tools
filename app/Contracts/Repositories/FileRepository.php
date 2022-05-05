<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface FileRepository
{
    /**
     * Load from the file.
     *
     * @return string
     */
    public function loadFromFile(): string;

    /**
     * Load the data from the database.
     *
     * @return Collection
     */
    public function loadFromDatabase(): Collection;

    /**
     * Get the settings database repository.
     *
     * @return DatabaseRepository
     */
    public function database(): DatabaseRepository;

    /**
     * Save the current data to the file.
     *
     * @return void
     */
    public function save(): void;

    /**
     * Write the changes to the database.
     *
     * @return bool
     */
    public function write(): bool;

    /**
     * Get the full file path.
     *
     * @return string
     */
    public function file(): string;

    /**
     * Initialize.
     *
     * @return void
     */
    public function initialize(): void;

    /**
     * Reload the file from the database.
     *
     * @return void
     */
    public function reload(): void;

    /**
     * Is the file different from the database?
     *
     * @return bool
     */
    public function hasChanged(): bool;

    /**
     * Get the time the file was last updated.
     *
     * @return Carbon
     */
    public function lastUpdated(): Carbon;

    /**
     * Get the status of the FileRepository.
     *
     * @return Collection
     */
    public function status(): Collection;

    /**
     * Get the data.
     *
     * @return Collection
     */
    public function collection(): Collection;

    /**
     * Set the collection.
     *
     * @param Collection $collection
     * @return $this
     */
    public function setCollection(Collection $collection): static;

    /**
     * Get all the data.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * New instance of self.
     *
     * @return static
     */
    public static function instance(): static;
}
