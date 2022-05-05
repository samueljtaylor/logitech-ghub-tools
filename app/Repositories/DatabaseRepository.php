<?php

namespace App\Repositories;

use App\Connectors\AppDatabase;
use App\Collections\SettingsCollection;
use App\Contracts\Repositories\DatabaseRepository as DatabaseRepositoryContract;
use App\Services\GHubValidator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Collection;

class DatabaseRepository implements DatabaseRepositoryContract
{
    /**
     * @var AppDatabase
     */
    protected AppDatabase $connector;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->connector = App::make(AppDatabase::class);
    }

    /**
     * @inheritDoc
     */
    public function get(): SettingsCollection
    {
        return SettingsCollection::newFromJson($this->connector()->get());
    }

    /**
     * @inheritDoc
     */
    public function update(Collection $collection): bool
    {
        return $this->connector()->update(new GHubValidator($collection->toJson()));
    }

    /**
     * @inheritDoc
     */
    public function connector(): AppDatabase
    {
        return $this->connector;
    }


}
