<?php

namespace App\Contracts\Repositories;

use App\Contracts\Collections\CollectionContract;
use App\Contracts\Connectors\AppDatabase;
use Illuminate\Support\Collection;

interface DatabaseRepository
{
    /**
     * Get the settings from the database.
     *
     * @return Collection
     */
    public function get(): Collection;

    /**
     * Update the database.
     *
     * @param Collection $collection
     * @return bool
     */
    public function update(Collection $collection): bool;

    /**
     * Get the AppDatabase connector.
     *
     * @return AppDatabase
     */
    public function connector(): AppDatabase;
}
