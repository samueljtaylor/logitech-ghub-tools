<?php

namespace App\Contracts\JsonModels;

use App\Repositories\FileRepository;
use Illuminate\Support\Collection;

interface JsonModel
{
    /**
     * Get all models.
     *
     * @return Collection<int, static>
     */
    public static function all(): Collection;

    /**
     * Begin querying the model.
     *
     * @return Collection
     */
    public static function query(): Collection;

    /**
     * Get a new file repository instance.
     *
     * @return Collection
     */
    public function newQuery(): Collection;

    /**
     * Get the file repository.
     *
     * @return FileRepository
     */
    public function repository(): FileRepository;

    /**
     * Get or guess the model's key.
     *
     * @return string
     */
    public function getModelKey(): string;

    /**
     * Guess the model's key.
     *
     * @return string
     */
    public function guessModelKey(): string;

    /**
     * Update the model.
     *
     * @param array $attributes
     * @return void
     */
    public function update(array $attributes): void;

    /**
     * Save the model data.
     *
     * @return void
     */
    public function save(): void;

    /**
     * Delete this model.
     *
     * @return void
     */
    public function delete(): void;

    /**
     * Create a new model.
     *
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes): static;

    /**
     * Create a new model from JSON.
     *
     * @param string $json
     * @return static
     */
    public static function createFromJson(string $json): static;

    /**
     * Fill attributes.
     *
     * @param iterable $attributes
     * @return void
     */
    public function fill(iterable $attributes = []): void;
}
