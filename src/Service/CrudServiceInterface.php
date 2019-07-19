<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface CrudServiceInterface
{
    public function find($id): ?object;

    public function findAll(): array;

    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator;

    public function create(object $entity): object;

    public function update(object $entity): object;

    public function remove(object $entity): void;

    public function save(object $entity): object;
}
