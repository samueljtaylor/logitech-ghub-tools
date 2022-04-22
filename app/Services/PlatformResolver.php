<?php

namespace App\Services;

use App\Contracts\PathBuilders\PathBuilder;
use App\Contracts\Resolvers\PlatformResolver as PlatformResolverContract;
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
     * @var PathBuilder
     */
    protected PathBuilder $pathBuilder;

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
        $this->platform ??= Platform::resolve($this->agent->platform() ?: config('ghub.platform'));
        return $this->platform;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function pathBuilder(): PathBuilder
    {
        $this->pathBuilder ??= $this->platform()->builder();
        return $this->pathBuilder;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public static function resolvePathBuilder(): PathBuilder
    {
        return (new static)->pathBuilder();
    }
}
