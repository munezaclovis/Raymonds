<?php

declare(strict_types=1);

namespace Raymonds\Orm\DataMapper;

use Raymonds\Orm\DataMapper\DataMapperInterface;
use Raymonds\DatabaseConnection\DatabaseConnectionInterface;
use Raymonds\Orm\DataMapper\Exception\DataMapperException;

class DataMapperFactory
{

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Create new DataMapper instance
     *
     * @param string $databaseString
     * @param string $dataMapperConfiguration
     * @return DataMapperInterface
     * @throws DataMapperException
     */
    public function create(string $databaseConnectionString, string $dataMapperConfiguration): DataMapperInterface
    {
        $credentials = (new $dataMapperConfiguration([]))->getDatabaseCredentials('mysql');
        $databaseConnectionObject = new $databaseConnectionString($credentials);

        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new DataMapperException($databaseConnectionString . ' is not a valid database connection interface');
        }
        return new DataMapper($databaseConnectionObject);
    }
}
