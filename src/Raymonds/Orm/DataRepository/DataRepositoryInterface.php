<?php

declare(strict_types=1);

namespace Raymonds\Orm\DataRepository;

interface DataRepositoryInterface
{
    public function find(int $id): array;

    public function findAll(): array;

    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array;

    public function findOneBy(array $conditions): array;

    public function findObjectBy(array $selectors = [], array $conditions = []): Object;

    public function search(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array;

    public function delete(array $conditions = []): bool;

    public function update(string $primaryKey, array $conditions = []): bool;

    public function searchByPaging(array $args, Object $request): array;

    public function findAndReturn(int $id, array $selectors): self;
}
