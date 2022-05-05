<?php

namespace App\JsonModels;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Card extends JsonModel
{
    protected $guarded = [];

    public function readOnly(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'true' : 'false',
            set: fn ($value) => filter_var($value, FILTER_VALIDATE_BOOLEAN)
        );
    }

    public static function getDefaultValues(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'name' => '',
            'category' => '',
            'macro' => [
                'type' => 'keystroke',
                'actionName' => '',
                'keystroke' => [
                    'code' => '',
                    'modifiers' => [],
                ],
            ],
            'applicationId' => Application::defaultId(),
            'attribute' => 'MACRO_PLAYBACK',
            'profileId' => Profile::defaultId(),
            'readOnly' => true,
        ];
    }
}
