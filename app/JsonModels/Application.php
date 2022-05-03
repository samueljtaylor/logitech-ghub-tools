<?php

namespace App\JsonModels;

use Illuminate\Support\Str;

class Application extends JsonModel
{

    protected $guarded = [];

    public static function names(): array
    {
        $list = [];

        foreach(static::all() as $application) {
            $list[$application->applicationId] = $application->name;
        }

        return $list;
    }

    public static function defaultId(): string
    {
        $names = static::names();

        foreach($names as $id => $name) {
            if(Str::contains($name, 'desktop', true)) {
                return $id;
            }
        }

        return array_key_first($names) ?? Str::uuid()->toString();
    }
}
