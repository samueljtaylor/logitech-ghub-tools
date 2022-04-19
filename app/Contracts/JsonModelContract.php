<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface JsonModelContract
{
    /**
     * Fill the model's attributes.
     *
     * @param array $attributes
     * @return void
     */
    public function fill(array $attributes): void;

    /**
     * Get an attribute.
     *
     * @param string $field
     * @return mixed
     */
    public function getAttribute(string $field): mixed;

    /**
     * Set an attribute.
     *
     * @param string $field
     * @param mixed $value
     * @return void
     */
    public function setAttribute(string $field, mixed $value): void;

    /**
     * Save the model.
     *
     * @return void
     */
    public function save(): void;

    /**
     * Find a model by id.
     *
     * @param string $id
     * @return $this
     */
    public function findById(string $id): static;

    /**
     * The JsonFileRepository.
     *
     * @return JsonFileRepositoryContract
     */
    public function repository(): JsonFileRepositoryContract;

    /**
     * Get the stored data from the repository.
     *
     * @return Collection
     */
    public function storedData(): Collection;

    /**
     * Get this model's specific data from the repository.
     *
     * @return Collection
     */
    public function modelData(): Collection;

    /**
     * New instance.
     *
     * @return static
     */
    public static function instance(): static;

    /**
     * Get all of this model.
     *
     * @return Collection
     */
    public static function all(): Collection;

    /**
     * Search for a specific model.
     *
     * @param string $key
     * @param mixed $operator
     * @param mixed $value
     * @return Collection
     */
    public static function where(string $key, mixed $operator, mixed $value = null): Collection;

    /**
     * Find a model by id.
     *
     * @param string $id
     * @return static
     */
    public static function find(string $id): static;
}
