<?php

declare(strict_types=1);


namespace Raymonds\Orm\DataMapper;

interface DataMapperInterface
{

    /**
     * Prepare the sql query
     *
     * @param string $query
     * @return self
     */
    public function prepare(string $query): self;

    /**
     * Bind parameters to the PDO instance using the PDO::PARAM_* constants.
     *
     * @param mixed $value
     * @return mixed
     * @throws DataMapperException
     */
    public function bind(mixed $value): mixed;

    /**
     * Combination method which combines both methods above. One of which  is
     * optimized for binding search queries. Once the second argument $type
     * is set to search
     *
     * @param array $fields
     * @param boolean $isSearch
     * @return self
     */
    public function bindParameters(array $fields, bool $isSearch = false): self;

    /**
     * returns the number of rows affected by a DELETE, INSERT, or UPDATE statement.
     * 
     * @return int|null
     */
    public function numRows(): int;

    /**
     * Execute function which will execute the prepared statement
     * 
     * @return bool
     */
    public function execute(): bool;

    /**
     * Returns a single database row as an object
     * 
     * @return Object
     */
    public function result(): Object;

    /**
     * Returns all the rows within the database as an array
     * 
     * @return array
     */
    public function results(): array;

    /**
     * Returns a database column
     * 
     * @return mixed
     */
    public function column();

    /**
     * Returns the last inserted row ID from database table
     * 
     * @return int
     * @throws Throwable
     */
    public function getLastId(): int;
}
