<?php

namespace App\Collections\Macros;

use Illuminate\Support\Collection;

class IsSameAs
{
    public function __invoke(): callable
    {
        return function (Collection $collection): bool {
            return $this == $collection;
        };
    }
}
