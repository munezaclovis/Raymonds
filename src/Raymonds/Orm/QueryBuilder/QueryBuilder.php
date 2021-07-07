<?php

declare(strict_types=1);

namespace Raymonds\Orm\QueryBuilder;

use Raymonds\Orm\QueryBuilder\QueryBuilderInterface;
use Raymonds\Orm\QueryBuilder\Exception\QueryBuilderInvalidArgumentException;


class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @var array
     */
    protected array $key;

    /**
     * @var string
     */
    protected string $sqlQuery;

    /**
     * @var array
     */
    protected const SQL_DEFAULT = [
        'conditions' => [],
        'selectors' => [],
        'replace' => false,
        'distinct' => false,
        'form' => [],
        'where' => null,
        'and' => [],
        'or' => [],
        'orderBy' => [],
        'fields' => [],
        'primary_key' => '',
        'table' => '',
        'type' => '',
        'raw' => '',
    ];

    /**
     * @var array
     */
    protected const QUERY_TYPE = ['insert', 'select', 'update', 'delete', 'search', 'raw'];

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * merge array of arguments and set the key variable 
     *
     * @param array $args
     * @return self
     */
    public function buildQuery(array $args = []): self
    {
        if (count($args) < 0) {
            throw new QueryBuilderInvalidArgumentException();
        }
        $arg = array_merge(self::SQL_DEFAULT, $args);
        $this->key = $arg;
        return $this;
    }

    /**
     * check if query type is supported/valid
     *
     * @param string $type
     * @return boolean
     */
    public function isValidQueryType(string $type): bool
    {
        if (in_array($type, self::QUERY_TYPE)) {
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function insertQuery(): string
    {
        if ($this->isValidQueryType('insert')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $index = array_keys($this->key['fields']);
                $fields = implode(', ', $index);
                $values = ':' . implode(', :', $index);
                $this->sqlQuery = "INSERT INTO `{$this->key['table']}` ({$fields}) VALUES ({$values})";
                return $this->sqlQuery;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function selectQuery(): string
    {
        if ($this->isValidQueryType('select')) {
            $selectors = (!empty($this->key['selectors'])) ? implode(', ', $$this->key['selectors']) : '*';
            $this->sqlQuery = "SELECT {$selectors} FROM {$this->key['table']}";
            $this->sqlQuery = $this->hasConditions();
            return $this->sqlQuery;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function updateQuery(): string
    {
        if ($this->isValidQueryType('update')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $valuesFields = '';
                foreach ($this->key['fields'] as $field) {
                    if ($field !== $this->key['primary_key']) {
                        $valuesFields .= $field . ' = :' . $field . ', ';
                    }
                }
                $valuesFields = rtrim($valuesFields, ', ');
                $this->sqlQuery = "UPDATE {$this->key['table']} SET {$valuesFields} WHERE {$this->key['primary_key']} = :{$this->key['primary_key']} LIMIT 1";

                if (isset($this->key['primary_key']) && $this->key['primary_key'] === '0') {
                    unset($this->key['primary_key']);
                    $this->sqlQuery = "UPDATE {$this->key['table']} SET {$valuesFields}";
                }
                return $this->sqlQuery;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function deleteQuery(): string
    {
        if ($this->isValidQueryType('delete')) {
            $index = array_keys($this->key['conditions']);
            $this->sqlQuery = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]} LIMIT 1";
            $bulkDelete = array_values($this->key['fields']);
            if (is_array($bulkDelete) && count($bulkDelete) > 1) {
                for ($i = 0; $i < count($bulkDelete); $i++) {
                    $this->sqlQuery = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]}";
                }
            }
            return $this->sqlQuery;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function rawQuery(): string
    {
        if ($this->isValidQueryType('raw')) {
            $this->sqlQuery = $this->key['raw'];
            return $this->sqlQuery;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function searchQuery(): string
    {
        if ($this->isValidQueryType('search')) {
            $selectors = (!empty($this->key['selectors'])) ? implode(', ', $$this->key['selectors']) : '*';
            $this->sqlQuery = "SELECT {$selectors} FROM {$this->key['table']}";
            $this->sqlQuery = $this->hasConditions();
            return $this->sqlQuery;
        }
        return false;
    }

    /**
     * extract from query conditions and add them on the original query
     *
     * @return string
     */
    private function hasConditions(): string
    {
        if (isset($this->key['conditions']) && $this->key['conditions' != '']) {
            if (is_array($this->key['conditions'])) {
                $sort = [];
                foreach (array_keys($this->key['conditions']) as $where) {
                    if (isset($where) && $where != '') {
                        $sort[] = $where . " = :" . $where;
                    }
                }
                if (count($this->key['conditions']) > 0) {
                    $this->sqlQuery .= " WHERE " . implode(" AND ", $sort);
                }
            }
        } else if (empty($this->key['conditions'])) {
            $this->sqlQuery .= " WHERE 1";
        }

        if (isset($this->key['orderBy']) && $this->key['orderBy'] != '') {
            $this->sqlQuery .= " ORDER BY {$this->key['orderBy']}";
        }

        if (isset($this->key['limit']) && $this->key['offset'] != -1) {
            $this->sqlQuery .= " LIMIT :offset, :limit";
        }
        return $this->sqlQuery;
    }
}
