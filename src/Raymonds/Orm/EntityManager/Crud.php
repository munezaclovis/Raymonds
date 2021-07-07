<?php

declare(strict_types=1);

namespace Raymonds\Orm\EntityManager;

use Raymonds\Orm\DataMapper\DataMapper;
use Raymonds\Orm\QueryBuilder\QueryBuilder;
use Raymonds\Orm\EntityManager\CrudInterface;

class Crud implements CrudInterface
{

    /**
     * @var DataMapper
     */
    protected DataMapper $dataMapper;

    /**
     * @var QueryBuilder
     */
    protected QueryBuilder $queryBuilder;

    /**
     * @var string
     */
    protected string $tableName;

    /**
     * @var string
     */
    protected string $tablePrimaryKey;

    /**
     * Construct
     *
     * @param DataMapper $dataMapper
     * @param QueryBuilder $queryBuilder
     * @param string $tableName
     * @param string $tablePrimaryKey
     */
    public function __construct(DataMapper $dataMapper, QueryBuilder $queryBuilder, string $tableName, string $tablePrimaryKey)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
        $this->tableName = $tableName;
        $this->tablePrimaryKey = $tablePrimaryKey;
    }

    /** 
     * @inheritDoc
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /** 
     * @inheritDoc
     */
    public function getTablePrimaryKey(): string
    {
        return $this->tablePrimaryKey;
    }

    /**
     * @inheritDoc
     */
    public function lastID(): int
    {
        return $this->dataMapper->getLastId();
    }

    /**
     * @inheritDoc
     */
    public function create(array $fields = []): bool
    {
        try {
            $args = [
                'table' => $this->getTableName(),
                'type' => 'insert',
                'fields' => $fields,
            ];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
    {
        try {
            $args = [
                'table' => $this->getTableName(),
                'type' => 'select',
                'selectors' => $selectors,
                'conditions' => $conditions,
                'params' => $parameters,
            ];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions, $parameters));
            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results();
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function update(array $fields = [], string $primaryKey): bool
    {
        try {
            $args = [
                'table' => $this->getTableName(),
                'type' => 'update',
                'fields' => $fields,
                'primary_key' => $primaryKey,
            ];
            $query = $this->queryBuilder->buildQuery($args)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() > 0) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(array $conditions = []): bool
    {
        try {
            $args = [
                'table' => $this->getTableName(),
                'type' => 'delete',
                'conditions' => $conditions,
            ];
            $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() > 0) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function search(array $selectors = [], array $conditions = []): array
    {
        try {
            $args = [
                'table' => $this->getTableName(),
                'type' => 'search',
                'conditions' => $conditions,
                'selectors' => $selectors,
            ];
            $query = $this->queryBuilder->buildQuery($args)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions), true);
            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results();
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function rawQuery(string $rawQuery, array $conditions = []): bool
    {
        try {
            $args = [
                'table' => $this->getTableName(),
                'type' => 'raw',
                'conditions' => $conditions,
                'raw' => $rawQuery,
            ];
            $query = $this->queryBuilder->buildQuery($args)->rawQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() > 0) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
