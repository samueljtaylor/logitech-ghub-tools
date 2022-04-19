<?php

namespace App\Contracts;

interface PathBuilderContract
{
    /**
     * The base path to the settings.
     *
     * @return string
     */
    public function baseSettingsPath(): string;

    /**
     * The base path to the application root.
     *
     * @return string
     */
    public function applicationPath(): string;

    /**
     * The application filename.
     *
     * @return string
     */
    public function applicationFilename(): string;

    /**
     * The database filename.
     *
     * @return string
     */
    public function databaseFilename(): string;

    /**
     * Build the full path to database.
     *
     * @return string
     */
    public function buildDatabasePath(): string;

    /**
     * Build the full path to application.
     *
     * @return string
     */
    public function buildApplicationPath(): string;

    /**
     * The OS the app is running on.
     *
     * @return string
     */
    public function platform(): string;

    /**
     * Alias for buildApplicationPath().
     *
     * @return string
     */
    public function application(): string;

    /**
     * Alias for buildDatabasePath().
     *
     * @return string
     */
    public function database(): string;

    /**
     * Get a new instance of the PathBuilder.
     *
     * @return static
     */
    public static function instance(): PathBuilderContract;
}
