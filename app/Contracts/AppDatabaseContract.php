<?php

namespace App\Contracts;

use PDO;
use PDOStatement;

interface AppDatabaseContract
{
    /**
     * Constructor.
     *
     * @param PathBuilderContract $pathBuilder
     */
    public function __construct(PathBuilderContract $pathBuilder);

    /**
     * Get the PathBuilder.
     *
     * @return PathBuilderContract
     */
    public function path(): PathBuilderContract;

    /**
     * The select query.
     *
     * @return string
     */
    public function selectQuery(): string;

    /**
     * The update query.
     *
     * @return string
     */
    public function updateQuery(): string;

    /**
     * Get the PDO instance.
     *
     * @return PDO
     */
    public function pdo(): PDO;

    /**
     * Get the select PDOStatement.
     *
     * @return PDOStatement
     */
    public function select(): PDOStatement;

    /**
     * Fetch the data.
     *
     * @param int $mode
     * @return mixed
     */
    public function fetch(int $mode = PDO::FETCH_ASSOC): mixed;

    /**
     * The update PDOStatement.
     *
     * @return PDOStatement
     */
    public function updateStatement(): PDOStatement;

    /**
     * Perform the update.
     *
     * @param string $json
     * @return bool
     */
    public function performUpdate(string $json): bool;

    /**
     * Get the selected data.
     *
     * @return mixed
     */
    public function get(): mixed;

    /**
     * Update the database.
     *
     * @param string $json
     * @return bool
     */
    public function update(string $json): bool;
}
