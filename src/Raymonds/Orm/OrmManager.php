<?php

declare(strict_types=1);

namespace Raymonds\Orm;

use Raymonds\Orm\EntityManager\Crud;
use Raymonds\Orm\QueryBuilder\QueryBuilder;
use Raymonds\DatabaseConnection\DatabaseConnection;
use Raymonds\Orm\DataMapper\DataMapper;
use Raymonds\Orm\DataMapper\DataMapperConfiguration;
use Raymonds\Orm\EntityManager\EntityManager;
use Raymonds\Yaml\Config;

class OrmManager
{
    protected string $tableName;

    protected string $primaryKey;

    public function __construct(string $tableName, string $primaryKey)
    {
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
    }

    public function initialize(): Crud
    {
        $credentials = (new DataMapperConfiguration(Config::file('database')['driver']))->getDatabaseCredentials(Config::file('app')['database_driver']);
        $dataMapper = new DataMapper(new DatabaseConnection($credentials));
        if ($dataMapper) {
            $queryBuilder = new QueryBuilder;
            if ($queryBuilder) {
                return new Crud($dataMapper, $queryBuilder, $this->tableName, $this->primaryKey);
            }
        }
    }
}
