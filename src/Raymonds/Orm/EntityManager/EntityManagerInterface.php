<?php

declare(strict_types=1);

namespace Raymonds\Orm\EntityManager;

interface EntityManagerInterface
{
    /**
     * get crud variable
     *
     * @return Object
     */
    public function getCrud(): CrudInterface;
}
