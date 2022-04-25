<?php

namespace App\Collections;

use Illuminate\Support\Str;

class KeyCollection extends Collection
{
    /**
     * Perform a full search by key, name and search term.
     *
     * @param string $term
     * @return $this
     */
    public function fullSearch(string $term): static
    {
        return $this->filter(function ($item, $key) use ($term) {
            if(Str::contains($key, $term, true)) {
                return true;
            }

            if(Str::contains($item?->get('name') ?? '', $term, true)) {
                return true;
            }

            foreach($item?->get('terms') ?? [] as $termItem) {
                if(Str::contains($termItem, $term, true)) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * Is the key a modifier key?
     *
     * @return bool
     */
    public function isModifier(): bool
    {
        return $this->get('modifier') ?? false;
    }
}
