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

    public function find(int $id): array
    {
        $this->isEmpty($id);
        return $this->findOneBy(['id' => $id]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getCrud()->select();
    }

    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
    {
        return $this->entityManager->getCrud()->select($selectors, $conditions, $parameters, $optional);
    }

    public function findOneBy(array $conditions): array
    {
        $this->isArray($conditions);
        return $this->entityManager->getCrud()->select([], $conditions);
    }

    public function findObjectBy(array $selectors = [], array $conditions = []): object
    {
        return new stdClass;
        //return json_decode(json_encode($this->entityManager->getCrud()->select($selectors, $conditions)), false);
    }

    public function search(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
    {
        $this->isArray($conditions);
        return $this->entityManager->getCrud()->search($selectors, $conditions, $parameters, $optional);
    }

    public function delete(array $conditions = []): bool
    {
        $this->isArray($conditions);
        return $this->entityManager->getCrud()->delete($conditions);
    }

    public function update(string $primaryKey, array $conditions = []): bool
    {
        $this->isArray($conditions);
        return $this->entityManager->getCrud()->update($primaryKey, $conditions);
    }

    public function findAndReturn(int $id, array $selectors = []): self
    {
        return $this;
    }

    public function searchByPaging(array $args, object $request): array
    {
        return [];
    }
}
