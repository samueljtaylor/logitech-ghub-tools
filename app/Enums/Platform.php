<?php

namespace App\Enums;

use App\Contracts\PathBuilders\PathBuilder;
use App\PathBuilders\DockerPathBuilder;
use App\PathBuilders\MacPathBuilder;
use App\PathBuilders\OtherPathBuilder;
use Exception;
use Jenssegers\Agent\Agent;

enum Platform
{
    case MacOS;
    case Windows;
    case Linux;
    case Docker;
    case Other;

    /**
     * Resolve OS to PathBuilder class.
     *
     * @return string
     * @throws Exception
     */
    public function builderClass(): string
    {
        return match($this) {
            self::MacOS => MacPathBuilder::class,
            self::Windows, self::Linux => throw new Exception('To be implemented'),
            self::Docker => DockerPathBuilder::class,
            self::Other => OtherPathBuilder::class
        };
    }

    /**
     * Return new instance of PathBuilder class.
     *
     * @throws Exception
     */
    public function builder(): PathBuilder
    {
        $class = $this->builderClass();
        return new $class();
    }

    /**
     * New platform from string.
     *
     * @param string $platform
     * @return Platform
     */
    public static function resolve(string $platform): Platform
    {
        return match($platform) {
            'OS X' => Platform::MacOS,
            'Windows' => Platform::Windows,
            'Linux' => Platform::Linux,
            'Docker' => Platform::Docker,
            default => Platform::Other
        };
    }
}
