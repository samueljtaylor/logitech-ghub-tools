<?php

namespace App\Services;

use App\Contracts\PathBuilderContract;
use App\Contracts\PlatformResolverContract;
use App\Enums\Platform;
use Exception;
use Jenssegers\Agent\Agent;

class PlatformResolver implements PlatformResolverContract
{
    /**
     * @var Agent
     */
    protected Agent $agent;

    /**
     * @var PathBuilderContract
     */
    protected PathBuilderContract $pathBuilder;

    /**
     * @var Platform
     */
    protected Platform $platform;

    /**
     * PlatformResolver constructor.
     */
    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * @inheritDoc
     */
    public function platform(): Platform
    {
        $this->platform ??= Platform::fromAgent($this->agent);
        return $this->platform;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function pathBuilder(): PathBuilderContract
    {
        $this->pathBuilder ??= $this->platform()->builder();
        return $this->pathBuilder;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public static function resolvePathBuilder(): PathBuilderContract
    {
        return (new static)->pathBuilder();
    }
}
