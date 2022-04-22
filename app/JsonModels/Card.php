<?php

namespace App\JsonModels;

use Illuminate\Database\Eloquent\Casts\Attribute;

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

}
