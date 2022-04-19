<?php

namespace App\Traits;

trait HasNullableConfig
{
    /**
     * Return the config or default, but treat null as not found.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function config(string $key, mixed $default = null): mixed
    {
        return config($key) ?? $default;
    }
}
