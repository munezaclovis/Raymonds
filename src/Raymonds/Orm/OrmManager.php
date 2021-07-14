<?php

declare(strict_types=1);

namespace Raymonds\Orm;

use Raymonds\Orm\EntityManager\Crud;
use Raymonds\Orm\QueryBuilder\QueryBuilder;
use Raymonds\Orm\DataMapper\DataMapperFactory;
use Raymonds\Orm\QueryBuilder\QueryBuilderFactory;
use Raymonds\DatabaseConnection\DatabaseConnection;
use Raymonds\Orm\DataMapper\DataMapperConfiguration;
use Raymonds\Orm\EntityManager\EntityManagerFactory;

class OrmManager
{
    protected string $tableName;

    protected string $primaryKey;

    protected DataMapperConfiguration $environmentConfiguration;

    public function __construct(DataMapperConfiguration $environmentConfiguration, string $tableName, string $primaryKey)
    {
        $this->environmentConfiguration = new $environmentConfiguration;
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
    }

    public function initialize()
    {
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DatabaseConnection::class, DataMapperConfiguration::class);
        if ($dataMapper) {
            $queryBuilderFactory = new QueryBuilderFactory();
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
            if ($queryBuilder) {
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
                return $entityManagerFactory->create(Crud::class, $this->tableName, $this->primaryKey);
            }
        }
    }
}
