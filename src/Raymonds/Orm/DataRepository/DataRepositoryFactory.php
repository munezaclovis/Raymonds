<?php

declare(strict_types=1);

namespace Raymonds\Orm\DataRepository;

use Raymonds\Orm\DataRepository\DataRepositoryInterface;

class DataRepositoryFactory
{
    protected string $tableName;

    protected string $primaryKey;

    protected string $crudIdentifier;

    public function __construct(string $crudIdentifier, string $tableName, string $primaryKey)
    {
        $this->crudIdentifier = $crudIdentifier;
        $this->tableName = $tableName;
        $this->primaryKey = $primaryKey;
    }

    public function create(string $dataRepositoryString): DataRepositoryInterface
    {
        $dataRepositoryObject = new $dataRepositoryString;

        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new DataRepositoryException($dataRepositoryString . 'is not valid DataRepository object');
        }
        return $dataRepositoryObject;
    }
}
