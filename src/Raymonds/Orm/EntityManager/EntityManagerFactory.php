<?php

declare(strict_types=1);

namespace Raymonds\Orm\EntityManager;

use Raymonds\Orm\DataMapper\DataMapperInterface;
use Raymonds\Orm\EntityManager\Exception\CrudException;
use Raymonds\Orm\QueryBuilder\QueryBuilderInterface;

class EntityManagerFactory
{
    /**
     * @var DataMapperInterface
     */
    protected DataMapperInterface $dataMapper;

    /**
     * @var QueryBuilderInterface
     */
    protected QueryBuilderInterface $queryBuilder;

    /**
     * Constructor
     *
     * @param DataMapperInterface $dataMapper
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(DataMapperInterface $dataMapper, QueryBuilderInterface $queryBuilder)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * create new EntityManager instance
     *
     * @param string $crudString
     * @param string $tableName
     * @param string $primaryKey
     * @return EntityManagerInterface
     */
    public function create(string $crudString, string $tableName, string $primaryKey): EntityManagerInterface
    {
        $crudObject = new $crudString($this->dataMapper, $this->queryBuilder, $tableName, $primaryKey);
        if (!$crudObject instanceof CrudInterface) {
            throw new CrudException($crudString . ' is not a valid crud object');
        }
        return new EntityManager($crudObject);
    }
}
