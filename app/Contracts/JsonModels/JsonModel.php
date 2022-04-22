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
}
