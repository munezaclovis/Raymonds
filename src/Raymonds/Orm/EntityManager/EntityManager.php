<?php

declare(strict_types=1);

namespace Raymonds\Orm\EntityManager;

use Raymonds\Orm\EntityManager\EntityManagerInterface;
use Raymonds\Orm\EntityManager\CrudInterface;

class EntityManager implements EntityManagerInterface
{

    /**
     * @var CrudInterface
     */
    protected CrudInterface $crud;
    /**
     * Constructor
     */
    public function __construct(CrudInterface $crud)
    {
        $this->crud = $crud;
    }

    /**
     * @inheritDoc
     */
    public function getCrud(): CrudInterface
    {
        return $this->crud;
    }
}
