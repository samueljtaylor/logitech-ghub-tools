<?php

namespace App\Contracts;

use App\Enums\Platform;

interface PlatformResolverContract
{
    /**
     * Get the Platform enum.
     *
     * @return \App\Enums\Platform
     */
    public function platform(): Platform;

    /**
     * Get the PathBuilder.
     *
     * @return PathBuilderContract
     */
    public function pathBuilder(): PathBuilderContract;

    /**
     * Resolve the correct PathBuilder based on platform.
     *
     * @return PathBuilderContract
     */
    public static function resolvePathBuilder(): PathBuilderContract;
}
