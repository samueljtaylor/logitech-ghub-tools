<?php

namespace App\Repositories;

use App\Contracts\Repositories\FileRepository as FileRepositoryContract;
use App\Collections\SettingsCollection;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Traits\ForwardsCalls;


class FileRepository implements FileRepositoryContract
{
    use ForwardsCalls;

    /**
     * @var SettingsCollection
     */
    protected SettingsCollection $collection;

    /**
     * @var Carbon
     */
    protected Carbon $lastUpdated;

    /**
     * FileRepository constructor.
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
     */
    public function loadFromDatabase(): SettingsCollection
    {
        return $this->database()->get();
    }

    /**
     * @inheritDoc
     */
    public function database(): DatabaseRepository
    {
        return new DatabaseRepository();
    }

    /**
     * @inheritDoc
     */
    public function save(): void
    {
        $this->performSave($this->collection->toPrettyJson());
    }

    /**
     * @inheritDoc
     */
    public function write(): bool
    {
        return $this->database()->update($this->collection);
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
            $this->performSave($this->collection()->toPrettyJson());
        }

        $this->collection = SettingsCollection::newFromJson($this->loadFromFile());
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
        return !$this->collection()->isSameAs($this->loadFromDatabase());
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
     */
    public function collection(): SettingsCollection
    {
        $this->collection ??= $this->loadFromDatabase();
        return $this->collection;
    }

    /**
     * @inheritDoc
     */
    public function all(): SettingsCollection
    {
        return $this->collection();
    }

    /**
     * Forward calls to the collection object.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->forwardCallTo($this->collection(), $name, $arguments);
    }

    /**
     * Forward calls to collection object.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return static::instance()->$name($arguments);
    }

    /**
     * @inheritDoc
     */
    public static function instance(): static
    {
        return new static;
    }

}
