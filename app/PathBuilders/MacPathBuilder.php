<?php

namespace App\PathBuilders;

use Illuminate\Support\Str;

class MacPathBuilder extends PathBuilder
{
    /**
     * @inheritDoc
     */
    public function baseSettingsPath(): string
    {
        return $this->config('ghub.settings_path', Str::finish(getenv('HOME'),'/').'Library/Application Support/lghub');
    }

    /**
     * @inheritDoc
     */
    public function applicationPath(): string
    {
        return $this->config('ghub.application_path', '/Applications');
    }

    /**
     * @inheritDoc
     */
    public function applicationFilename(): string
    {
        return $this->config('ghub.application_filename', 'lghub.app');
    }

    /**
     * @inheritDoc
     */
    public function platform(): string
    {
        return 'macos';
    }

}
