<?php

declare(strict_types=1);


namespace Raymonds\Orm\DataMapper;

use PDO;
use PDOStatement;
use Raymonds\Orm\DataMapper\DataMapperInterface;
use Raymonds\Orm\DataMapper\Exception\DataMapperException;
use Raymonds\DatabaseConnection\DatabaseConnectionInterface;

class DataMapper implements DataMapperInterface
{
    /**
     * @var DatabaseConnectionInterface
     */
    private DatabaseConnectionInterface $db;

    /**
     * @var PDOStatement
     */
    private PDOStatement $statement;

    /**
     * Constructor
     */
    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    /**
     * Check the incoming $valis isn't empty else throw an exception
     * 
     * @param mixed $value
     * @param string|null $errorMessage
     * @return void
     * @throws DataMapperException
     */
    public function isEmpty($value, string $errorMessage = null): void
    {
        if (empty($value)) throw new DataMapperException($errorMessage);
    }

    /**
     * Check the incoming argument $value is an array else throw an exception
     * 
     * @param array $value
     * @return void
     * @throws DataMapperException
     */
    private function isArray(array $value): void
    {
        if (!is_array($value)) throw new DataMapperException('Your argument needs to be an array');
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $query): self
    {
        $this->statement = $this->db->open()->prepare($query);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function bind(mixed $value): mixed
    {
        try {
            switch ($value) {
                case is_bool($value):
                case intval($value):
                    $dataType = PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $dataType = PDO::PARAM_NULL;
                    break;
                default:
                    $dataType = PDO::PARAM_STR;
                    break;
            }
            return $dataType;
        } catch (DataMapperException $exception) {
            throw $exception;
        }
    }

    /**
     * Binds value to their corresponding placeholder in the SQL statement
     *
     * @param array $fields
     * @return PDOStatement
     * @throws DataMapperException
     */
    protected function bindValues(array $fields): PDOStatement
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key, $value, $this->bind($value));
        }
        return $this->statement;
    }

    /**
     * Binds value to their corresponding placeholder if its a search in the SQL statement
     *
     * @param array $fields
     * @return PDOStatement
     */
    protected function bindSearchValues(array $fields): PDOStatement
    {
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key, '%' . $value . '%', $this->bind($value));
        }
        return $this->statement;
    }

    /**
     * @inheritDoc
     */
    public function bindParameters(array $fields, bool $isSearch = false): self
    {
        if (is_array($fields)) {
            $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
            if ($type) return $this;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function execute(): bool
    {
        if ($this->statement) return $this->statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function numRows(): int
    {
        if ($this->statement) return $this->statement->rowCount();
    }

    /**
     * @inheritDoc
     */
    public function result(string $class = null): Object
    {
        if ($this->statement) return $this->statement->fetch(PDO::FETCH_CLASS, $class);
    }

    /**
     * @inheritDoc
     */
    public function results(string $class = null): array
    {
        if ($this->statement) return $this->statement->fetchAll(PDO::FETCH_CLASS, '\\' . $class);
    }

    /**
     * @inheritDoc
     */
    public function getLastId(): int
    {
        try {
            if ($this->db->open()) {
                $lastId = $this->db->open()->lastInsertId();
                if (!empty($lastId)) {
                    return intval($lastId);
                }
            }
        } catch (\Throwable $thowable) {
            throw $thowable;
        }
    }

    /**
     * @inheritDoc
     */
    public function column()
    {
        if ($this->statement) return $this->statement->fetchColumn();
    }

    /**
     * build query parameters
     *
     * @param array $conditions
     * @param array $parameters
     * @return array
     */
    public function buildQueryParameters(array $conditions = [], array $parameters = []): array
    {
        return (!empty($parameters) || (!empty($conditions)) ? array_merge($conditions, $parameters) : $conditions);
    }

    /**
     * Prepare the query, bind parameters then execute
     *
     * @param string $sqlQuery
     * @param array $parameters
     * @throws Throwable
     */
    public function persist(string $sqlQuery, array $parameters, bool $isSearch = false)
    {
        try {
            return $this->prepare($sqlQuery)->bindParameters($parameters)->execute();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
