<?php

namespace App\Services;

use App\Collections\KeyCollection;

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
     * Returns the first item from search function.
     *
     * @param string $term
     * @return KeyCollection
     */
    public function find(string $term): KeyCollection
    {
        $search = $this->search($term);
        $key = $search->keys()->first();
        return KeyCollection::newFromArray([$key => $search->first()]);
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
