<?php

namespace App\PathBuilders;

use App\PathBuilders\Exceptions\NeedsConfigException;

class OtherPathBuilder extends PathBuilder
{
    /**
     * @inheritDoc
     * @throws NeedsConfigException
     */
    public function baseSettingsPath(): string
    {
        return $this->returnOrThrow('ghub.settings_path');
    }

    /**
     * @inheritDoc
     * @throws NeedsConfigException
     */
    public function applicationPath(): string
    {
        return $this->returnOrThrow('ghub.application_path');
    }

    /**
     * @inheritDoc
     * @throws NeedsConfigException
     */
    public function applicationFilename(): string
    {
        return $this->returnOrThrow('ghub.application_filename');
    }

    /**
     * @inheritDoc
     * @throws NeedsConfigException
     */
    public function platform(): string
    {
        return $this->returnOrThrow('ghub.platform');
    }

    /**
     * Get the config value or throw an error.
     *
     * @param string $key
     * @return string
     * @throws NeedsConfigException
     */
    protected function returnOrThrow(string $key): string
    {
        $value = $this->config($key);

        if($value) {
            return $value;
        }

        $this->throwException($key);
    }

    /**
     * Throw a NeedsConfigException.
     *
     * @param string $missingKey
     * @return void
     * @throws NeedsConfigException
     */
    protected function throwException(string $missingKey): void
    {
        throw new NeedsConfigException('The '.$missingKey.' is missing and is required based on the platform being used.');
    }

}
