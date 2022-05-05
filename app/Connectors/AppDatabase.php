<?php

namespace App\Connectors;

use App\Contracts\Connectors\AppDatabase as AppDatabaseContract;
use App\Contracts\PathBuilders\PathBuilder;
use App\Traits\HasNullableConfig;
use PDO;
use PDOStatement;

class AppDatabase implements AppDatabaseContract
{
    use HasNullableConfig;

    /**
     * @var PathBuilder
     */
    protected PathBuilder $pathBuilder;

    /**
     * @inheritDoc
     */
    public function __construct(PathBuilder $pathBuilder)
    {
        $this->pathBuilder = $pathBuilder;
    }

    /**
     * @inheritDoc
     */
    public function path(): PathBuilder
    {
        return $this->pathBuilder;
    }

    /**
     * @inheritDoc
     */
    public function selectQuery(): string
    {
        return $this->config('ghub.select_query', /** @lang sqlite */ 'SELECT file FROM data');
    }

    /**
     * @inheritDoc
     */
    public function updateQuery(): string
    {
        return $this->config('ghub.update_query', /** @lang sqlite */ 'UPDATE data SET file = :json');
    }

    /**
     * @inheritDoc
     */
    public function pdo(): PDO
    {
        return new PDO('sqlite:'.$this->path()->database());
    }

    /**
     * @inheritDoc
     */
    public function select(): PDOStatement
    {
        return $this->pdo()->query($this->selectQuery());
    }

    /**
     * @inheritDoc
     */
    public function fetch(int $mode = PDO::FETCH_ASSOC): mixed
    {
        return $this->select()->fetch($mode);
    }

    /**
     * @inheritDoc
     */
    public function updateStatement(): PDOStatement
    {
        return $this->pdo()->prepare($this->updateQuery());
    }

    /**
     * @inheritDoc
     */
    public function performUpdate(string $json): bool
    {
        $statement = $this->updateStatement();
        $statement->bindValue('json', $json);
        return $statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function get(): mixed
    {
        return $this->fetch()['file'];
    }

    /**
     * @inheritDoc
     */
    public function update(string $json): bool
    {

        return $this->performUpdate($json);
    }

}
