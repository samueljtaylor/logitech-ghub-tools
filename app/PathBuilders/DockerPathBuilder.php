<?php

namespace App\PathBuilders;

class DockerPathBuilder extends PathBuilder
{

    /**
     * @inheritDoc
     */
    public function baseSettingsPath(): string
    {
        return storage_path('docker');
    }

    /**
     * @inheritDoc
     */
    public function applicationPath(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function applicationFilename(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function platform(): string
    {
        return 'Docker';
    }
}
