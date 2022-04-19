<?php

namespace App\Enums;

use App\Contracts\PathBuilderContract;
use App\PathBuilders\MacPathBuilder;
use App\PathBuilders\OtherPathBuilder;
use Exception;
use Jenssegers\Agent\Agent;

enum Platform
{
    case MacOS;
    case Windows;
    case Linux;
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
            self::Other => OtherPathBuilder::class
        };
    }

    /**
     * Return new instance of PathBuilder class.
     *
     * @throws Exception
     */
    public function builder(): PathBuilderContract
    {
        $class = $this->builderClass();
        return new $class();
    }

    /**
     * New platform from Agent instance.
     *
     * @param Agent $agent
     * @return Platform
     */
    public static function fromAgent(Agent $agent): Platform
    {
        return match($agent->platform()) {
            'OS X' => Platform::MacOS,
            'Windows' => Platform::Windows,
            'Linux' => Platform::Linux,
            default => Platform::Other
        };
    }
}
