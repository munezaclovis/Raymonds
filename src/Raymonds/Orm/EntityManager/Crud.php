<?php

declare(strict_types=1);

namespace Raymonds\Orm\EntityManager;

use Raymonds\Base\Exception\BaseInvalidArgumentException;
use Raymonds\Orm\DataMapper\DataMapper;
use Raymonds\Orm\QueryBuilder\QueryBuilder;
use Raymonds\Orm\EntityManager\CrudInterface;
use Raymonds\Traits\ArrayTrait;

class Crud implements CrudInterface
{
    use ArrayTrait;

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

    public function isValidArguments(array $keys, array $args)
    {
        $this->isArray($args);
        $this->isEmpty($args);
        $this->hasKeys($keys, $args);
    }

    /**
     * @inheritDoc
     *
     * @param array $fields
     * @return boolean
     */
    public function save(array $args = []): bool
    {
        try {
            $this->isValidArguments(['fields'], $args);
            $structure = [
                'table' => $this->getTableName(),
                'type' => 'insert',
                'fields' => $args['fields'],
            ];
            $query = $this->queryBuilder->buildQuery($structure)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($args['fields']));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     *
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $optional
     * @return array
     */
    public function select(array $args = []): array
    {
        try {
            $this->isValidArguments([], $args);
            $structure = [
                'table' => $this->getTableName(),
                'type' => 'select',
                'fields' => $args['fields'] ?? [],
                'conditions' => $args['conditions']['OR'] ?? $args['conditions']['or'] ?? $args['conditions'] ?? [],
            ];
            $query = $this->queryBuilder->buildQuery($structure)->selectQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($args['conditions']['OR'] ?? $args['conditions']['or'] ?? $args['conditions'] ?? []));

            if (isset($args['limit']) and $args['limit'] == 1)
                return $this->dataMapper->result($args['class'] ?? null);
            else
                return $this->dataMapper->results($args['class'] ?? null);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     *
     * @param array $fields
     * @param string $primaryKey
     * @return boolean
     */
    public function update(array $args = []): bool
    {
        try {
            $this->isValidArguments(['fields', 'primary_key'], $args);
            $structure = [
                'table' => $this->getTableName(),
                'type' => 'update',
                'fields' => $args['fields'],
                'primary_key' => $args['primary_key'],
            ];
            $query = $this->queryBuilder->buildQuery($structure)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($args['fields']));
            if ($this->dataMapper->numRows() > 0) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     *
     * @param array $conditions
     * @return boolean
     */
    public function delete(array $args = []): bool
    {
        try {
            $this->isValidArguments(['conditions'], $args);
            $structure = [
                'table' => $this->getTableName(),
                'type' => 'delete',
                'conditions' => $args['conditions'],
            ];
            $query = $this->queryBuilder->buildQuery($structure)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($args['conditions']));
            if ($this->dataMapper->numRows() > 0) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     *
     * @param array $selectors
     * @param array $conditions
     * @return array
     */
    public function search(array $args = []): array
    {
        try {
            $this->isValidArguments(['conditions'], $args);
            $structure = [
                'table' => $this->getTableName(),
                'type' => 'search',
                'conditions' => $args['conditions'],
                'selectors' => $args['selectors'] ?? [],
            ];
            $query = $this->queryBuilder->buildQuery($structure)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($args['conditions']), true);
            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results($args['class'] ?? null);
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     *
     * @param string $rawQuery
     * @param array|null $conditions
     * @return boolean
     */
    public function rawQuery(string $rawQuery, ?array $conditions = []): bool
    {
        try {
            $structure = [
                'table' => $this->getTableName(),
                'type' => 'raw',
                'conditions' => $conditions,
                'raw' => $rawQuery,
            ];
            $query = $this->queryBuilder->buildQuery($structure)->rawQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() > 0) {
                return true;
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
