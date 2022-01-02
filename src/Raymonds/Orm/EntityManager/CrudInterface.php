<?php

declare(strict_types=1);

namespace Raymonds\Orm\EntityManager;

interface CrudInterface
{
    /**
     * get table name
     *
     * @return string
     */
    public function getTableName(): string;

    /**
     * get table primary key
     *
     * @return string
     */
    public function getTablePrimaryKey(): string;

    /**
     * get last generated Id
     *
     * @return int
     */
    public function lastID(): int;

    /**
     * create/insert rows to database
     *
     * @param array $fields
     * @return bool
     */
    public function save(array $args = []): bool;

    /**
     * reacd/select row(s) from database
     *
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $optional
     * @return array
     */
    public function select(array $args = []): array;

    /**
     * update row in database
     *
     * @param array $fields
     * @param string $primaryKey
     * @return boolean
     */
    public function update(array $args): bool;

    /**
     * delete row from database
     *
     * @param array $conditions
     * @return boolean
     */
    public function delete(array $args = []): bool;

    /**
     * search row(s) in database
     *
     * @param array $selectors
     * @param array $conditions
     * @return array
     */
    public function search(array $args = []): array;

    /**
     * execute raw query in database
     *
     * @param string $rawQuery
     * @param array $conditions
     */
    public function rawQuery(string $rawQuery, array $conditions = []);
}
