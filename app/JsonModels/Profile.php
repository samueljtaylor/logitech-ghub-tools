<?php

namespace App\JsonModels;

use Illuminate\Support\Str;

class Profile extends JsonModel
{

    protected $guarded = [];

    public static function names(): array
    {
        $list = [];

        foreach(static::all() as $profile) {
            $list[$profile->id] = $profile->name;
        }

        return $list;
    }

    public static function defaultId(): string
    {
        $profiles = static::names();
        $appId = Application::defaultId();

        if(array_key_exists($appId, $profiles)) {
            return $appId;
        }

        foreach($profiles as $id => $name) {
            if(Str::contains($name, 'default', true)) {
                return $id;
            }
        }

        return Str::uuid()->toString();
    }
}
