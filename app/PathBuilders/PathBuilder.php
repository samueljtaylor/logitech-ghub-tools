<?php

namespace App\PathBuilders;

use App\Contracts\PathBuilderContract;
use App\Services\PlatformResolver;
use App\Traits\HasNullableConfig;
use Illuminate\Support\Str;

abstract class PathBuilder implements PathBuilderContract
{
    use HasNullableConfig;

    /**
     * @inheritDoc
     */
    public function databaseFilename(): string
    {
        return $this->config('ghub.database_filename', 'settings.db');
    }

    /**
     * @inheritDoc
     */
    public function buildDatabasePath(): string
    {
        return Str::finish($this->baseSettingsPath(), DIRECTORY_SEPARATOR).$this->databaseFilename();
    }

    /**
     * @inheritDoc
     */
    public function buildApplicationPath(): string
    {
        return Str::finish($this->applicationPath(), DIRECTORY_SEPARATOR).$this->applicationFilename();
    }

    /**
     * @inheritDoc
     */
    public function application(): string
    {
        return $this->buildApplicationPath();
    }

    /**
     * @inheritDoc
     */
    public function database(): string
    {
        return $this->buildDatabasePath();
    }

    /**
     * @inheritDoc
     */
    public static function instance(): PathBuilderContract
    {
        return PlatformResolver::resolve();
    }

}
