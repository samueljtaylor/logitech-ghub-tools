<?php

namespace App\Contracts\Resolvers;

use App\Contracts\PathBuilders\PathBuilder;
use App\Enums\Platform;

interface PlatformResolver
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
     * @return PathBuilder
     */
    public function pathBuilder(): PathBuilder;

    /**
     * Resolve the correct PathBuilder based on platform.
     *
     * @return PathBuilder
     */
    public static function resolvePathBuilder(): PathBuilder;
}
