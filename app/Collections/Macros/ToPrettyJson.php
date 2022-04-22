<?php

namespace App\Collections\Macros;

class ToPrettyJson
{
    public function __invoke(): callable
    {
        return function (): string {
            return $this->toJson(JSON_PRETTY_PRINT);
        };
    }
}
