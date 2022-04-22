<?php

namespace App\Collections\Macros;

use Illuminate\Support\Collection;

class Recursive
{
    public function __invoke(): callable
    {
        return function ($class = Collection::class): Collection {
            return $this->map(fn ($value) => is_array($value) ? (new $class($value))->recursive($class) : $value);
        };
    }

}
