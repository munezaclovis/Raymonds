<?php

declare(strict_types=1);

namespace Raymonds\Orm\DataRepository;

interface DataRepositoryInterface
{
    public function find(array $args): array;

    public function findAll(): array;

    public function findById(int $id): array;

    public function findOneBy(array $args): array;

    public function findObjectBy(array $args): Object;

    public function search(array $args): array;

    public function delete(array $args): bool;

    public function update(array $args): bool;

    public function searchByPaging(array $args): array;

    public function findAndReturn(array $args): self;
}
