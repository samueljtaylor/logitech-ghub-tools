<?php

namespace App\Contracts;

use Illuminate\Support\Carbon;

interface JsonFileRepositoryContract
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
     * @return SettingsCollectionContract
     */
    public function loadFromDatabase(): SettingsCollectionContract;

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
     * Get the data.
     *
     * @return SettingsCollectionContract
     */
    public function settings(): SettingsCollectionContract;

    /**
     * New instance of self.
     *
     * @return static
     */
    public static function instance(): static;
}
