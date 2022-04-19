<?php

namespace App\Resources;

use App\Contracts\AppDatabaseContract;
use App\Contracts\SettingsCollectionContract;
use App\Resources\Traits\CastsJson;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;

class SettingsCollection implements SettingsCollectionContract
{
    use CastsJson;

    /**
     * @var Collection
     */
    protected Collection $collection;

    /**
     * @inheritDoc
     */
    public static function newFromJson(string $json): static
    {
        return static::newFromArray(json_decode($json, true));
    }

    /**
     * @inheritDoc
     */
    public static function newFromArray(array $array): static
    {
        return static::newFromCollection(collect($array)->recursive());
    }

    /**
     * @inheritDoc
     */
    public static function newFromCollection(Collection $collection): static
    {
        $instance = new static;
        $instance->setCollection($collection);
        return $instance;
    }

    /**
     * @inheritDoc
     * @throws BindingResolutionException
     */
    public static function newFromDatabase(): static
    {
        return static::newFromJson(app()->make(AppDatabaseContract::class)->get());
    }


    /**
     * @inheritDoc
     */
    public function collection(): Collection
    {
        return $this->collection;
    }

    /**
     * @inheritDoc
     */
    public function setCollection(Collection $collection): void
    {
        $this->collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function isSameAs(SettingsCollectionContract $settingsCollection): bool
    {
        return $this->collection()->diffAssoc($settingsCollection->collection())->count() === 0;
    }

    /**
     * @inheritDoc
     */
    public function json(): string
    {
        return $this->collection()->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * @inheritDoc
     */
    public function writeToDatabase(): bool
    {
        return app()->make(AppDatabaseContract::class)->update($this->json());
    }


    /**
     * @inheritDoc
     */
    public function forwardMethodCall(string $name, array $arguments = []): mixed
    {
        return $this->collection()->$name(...$arguments);
    }

    /**
     * @inheritDoc
     */
    public function __call(string $name, array $arguments = []): mixed
    {
        return $this->forwardMethodCall($name, $arguments);
    }

    /**
     * @inheritDoc
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return (new static)->forwardMethodCall($name, $arguments);
    }
}
