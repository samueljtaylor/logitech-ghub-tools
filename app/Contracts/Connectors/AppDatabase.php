<?php

namespace App\Contracts\Connectors;

use App\Contracts\PathBuilders\PathBuilder;
use PDO;
use PDOStatement;

interface AppDatabase
{
    /**
     * Constructor.
     *
     * @param PathBuilder $pathBuilder
     */
    public function __construct(PathBuilder $pathBuilder);

    /**
     * Get the PathBuilder.
     *
     * @return PathBuilder
     */
    public function path(): PathBuilder;

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
