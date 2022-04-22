<?php

namespace App\JsonModels;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Card extends JsonModel
{
    protected $guarded = [];

    public function macro(): Attribute
    {
        return Attribute::make(
            get: fn ($macro) => json_encode($macro, JSON_PRETTY_PRINT),
            set: fn ($macro) => json_decode($macro, true)
        );
    }

    public function readOnly(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'true' : 'false',
            set: fn ($value) => filter_var($value, FILTER_VALIDATE_BOOLEAN)
        );
    }

}
