<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface CrudRepositoryInterface extends ObjectRepository
{
    public function persist(object $entity, bool $flush = true): object;

    public function merge(object $entity, bool $flush = false): object;

    public function flush(object $entity = null): void;

    public function detach(object $entity): void;

    public function removeById($id, bool $flush = false): void;

    public function remove(object $entity, bool $flush = false);

    /**
     * Removes all entities managed by the repository.
     *
     * @param bool $flush
     * @param bool $iterate Iterate over each entity so all triggers are called.
     */
    public function removeAll(bool $flush = false, bool $iterate = true);

    public function findPaginatedBy(
        int $page = 1,
        int $perPage = 10,
        array $criteria = [],
        array $orderBy = null
    ): Paginator;

    public function countAll(): int;
}
