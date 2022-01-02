<?php

declare(strict_types=1);

namespace Raymonds\Orm\DataRepository;

use Raymonds\Orm\EntityManager\EntityManagerInterface;
use Raymonds\Orm\DataRepository\DataRepositoryInterface;
use Raymonds\Orm\DataRepository\DataRepositoryInvalidArgumentException;
use stdClass;

class DataRepository implements DataRepositoryInterface
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function isArray(array $conditions): void
    {
        if (!is_array($conditions)) {
            throw new DataRepositoryInvalidArgumentException('The argument supplied is not an array');
        }
    }

    private function isEmpty(int $id): void
    {
        if (empty($id))
            throw new DataRepositoryInvalidArgumentException('Argument should not be empty');
    }

    public function find(array $args): array
    {
        return $this->entityManager->getCrud()->select($args);
    }

    public function findAll(): array
    {
        return $this->entityManager->getCrud()->select();
    }

    public function findById(int $id): array
    {
        return $this->entityManager->getCrud()->select(['conditions' => ['id' => $id]]);
    }

    public function findOneBy(array $args): array
    {
        $this->isArray($args);
        return $this->entityManager->getCrud()->select($args);
    }

    public function findObjectBy(array $args): object
    {
        return new stdClass;
        //return json_decode(json_encode($this->entityManager->getCrud()->select($selectors, $conditions)), false);
    }

    public function search(array $args): array
    {
        $this->isArray($args);
        return $this->entityManager->getCrud()->search($args);
    }

    public function delete(array $args): bool
    {
        $this->isArray($args);
        return $this->entityManager->getCrud()->delete($args);
    }

    public function update(array $args): bool
    {
        $this->isArray($args);
        return $this->entityManager->getCrud()->update($args);
    }

    public function findAndReturn(array $args): self
    {
        return $this;
    }

    public function searchByPaging(array $args): array
    {
        return [];
    }
}
