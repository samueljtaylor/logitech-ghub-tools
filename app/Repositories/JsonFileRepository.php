<?php

namespace App\Repositories;

use App\Contracts\JsonFileRepositoryContract;
use App\Contracts\SettingsCollectionContract;
use App\Resources\SettingsCollection;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Carbon;


class JsonFileRepository implements JsonFileRepositoryContract
{
    /**
     * @var SettingsCollectionContract
     */
    protected SettingsCollectionContract $settingsCollection;

    /**
     * @var Carbon
     */
    protected Carbon $lastUpdated;

    /**
     * JsonFileRepository constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @inheritDoc
     */
    public function loadFromFile(): string
    {
        return file_get_contents($this->file());
    }

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function loadFromDatabase(): SettingsCollectionContract
    {
        return SettingsCollection::newFromDatabase();
    }

    /**
     * @inheritDoc
     */
    public function save(): void
    {
        $this->performSave($this->settingsCollection->json());
    }

    /**
     * @inheritDoc
     */
    public function write(): bool
    {
        return $this->settingsCollection->writeToDatabase();
    }

    /**
     * @inheritDoc
     */
    public function file(): string
    {
        return database_path('json/ghub.json');
    }

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        if(!file_exists($this->file())) {
            $this->performSave($this->settings()->json());
        }

        $this->settingsCollection = SettingsCollection::newFromJson($this->loadFromFile());
        $this->lastUpdated = Carbon::parse(filemtime($this->file()));
    }

    public function performSave(string $json): void
    {
        file_put_contents($this->file(), $json);
    }

    /**
     * @inheritDoc
     */
    public function reload(): void
    {
        unlink($this->file());
        $this->initialize();
    }

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function hasChanged(): bool
    {
        return !$this->settings()->isSameAs($this->loadFromDatabase());
    }

    /**
     * @inheritDoc
     */
    public function lastUpdated(): Carbon
    {
        return $this->lastUpdated;
    }

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public function settings(): SettingsCollectionContract
    {
        $this->settingsCollection ??= $this->loadFromDatabase();
        return $this->settingsCollection;
    }

    /**
     * @inheritDoc
     */
    public static function instance(): static
    {
        return new static;
    }

}
