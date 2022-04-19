<?php

namespace App\Resources\Traits;

use Illuminate\Support\Collection;

trait CastsJson
{
    /**
     * Get the settings as a JSON string.
     *
     * @return string
     */
    public function asJson(): string
    {
        return $this->json;
    }

    /**
     * Get the settings as an instance of stdClass.
     *
     * Runs json_decode($settings, false);
     *
     * @return object
     */
    public function asObject(): object
    {
        return json_decode($this->asJson(), false);
    }

    /**
     * Get the settings as an associative array.
     *
     * Runs json_decode($settings, true);
     *
     * @return array
     */
    public function asArray(): array
    {
        return json_decode($this->asJson(), true);
    }

    /**
     * Get the settings as a Collection object.
     *
     * @return Collection
     */
    public function asCollection(): Collection
    {
        return collect($this->asArray())->recursive();
    }
}
