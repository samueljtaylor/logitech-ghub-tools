<?php

namespace App\Services;

use App\Collections\KeyCollection;
use Illuminate\Support\Str;

class KeyMapper
{
    /**
     * @var KeyCollection
     */
    protected KeyCollection $keymap;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->keymap = KeyCollection::newFromArray(config('ghub.keymap'));
    }

    /**
     * Search for a key.
     *
     * @param string $term
     * @return KeyCollection
     */
    public function search(string $term): KeyCollection
    {
        return $this->keymap()->fullSearch($term);
    }

    /**
     * Find a key.
     *
     * Search first by key, then do a full search and return first result.
     *
     * @param string $term
     * @return KeyCollection
     */
    public function find(string $term): KeyCollection
    {
        $result = $this->keymap()->get(Str::upper($term));

        if($result) {
            return KeyCollection::newFromArray([
                Str::upper($term) => $result
            ]);
        }

        $search = $this->search($term);

        if($search->count()) {
            return KeyCollection::newFromArray([
                $search->keys()->first() => $search->first()
            ]);
        }

        return new KeyCollection();
    }

    /**
     * Get by the collection key.
     *
     * @param string $key
     * @return KeyCollection
     */
    public function get(string $key): KeyCollection
    {
        return $this->keymap()->get($key) ?? new KeyCollection();
    }

    /**
     * Get the collection.
     *
     * @return KeyCollection
     */
    public function keymap(): KeyCollection
    {
        return $this->keymap;
    }
}
