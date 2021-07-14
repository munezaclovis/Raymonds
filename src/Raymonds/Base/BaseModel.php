<?php

declare(strict_types=1);

namespace Raymonds\Base;

use Raymonds\Base\Exception\BaseInvalidArgumentException;
use Raymonds\Orm\DataRepository\DataRepository;
use Raymonds\Orm\DataRepository\DataRepositoryFactory;

class BaseModel
{
    private string $tableName;

    private string $primaryKey;

    private Object $repository;

    public function __construct(string $primaryKey, string $tableName)
    {
        if (empty($primaryKey) || empty($tableName)) {
            throw new BaseInvalidArgumentException('Required arguments are missing');
        }
        $factory = new DataRepositoryFactory('', $tableName, $primaryKey);
        $this->repository = $factory->create(DataRepository::class);
    }

    public function getRepo()
    {
        return $this->repository;
    }
}
