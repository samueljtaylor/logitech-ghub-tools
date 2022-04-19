<?php

namespace App\JsonModels;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Card extends JsonModel
{
    /**
     * @inheritDoc
     */
    protected array $fields = [
        'applicationId',
        'attribute',
        'category',
        'id',
        'macro',
        'name',
        'profileId',
        'readOnly',
    ];

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
