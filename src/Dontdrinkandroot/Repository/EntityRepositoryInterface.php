<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface EntityRepositoryInterface extends ObjectRepository
{
    /**
     * @param mixed $entity
     * @param bool  $flush
     *
     * @return mixed
     */
    public function persist($entity, $flush = true);

    /**
     * @param mixed $entity
     * @param bool  $flush
     *
     * @return mixed
     */
    public function merge($entity, $flush = false);

    /**
     * @param object|array|null $entity
     */
    public function flush($entity = null);

    /**
     * @param mixed $entity
     */
    public function detach($entity);

    /**
     * @param mixed $id
     * @param bool  $flush
     */
    public function removeById($id, $flush = false);

    /**
     * @param mixed $entity
     * @param bool  $flush
     */
    public function remove($entity, $flush = false);

    /**
     * Removes all entities managed by the repository.
     *
     * @param bool $flush
     * @param bool $iterate Iterate over each entity so all triggers are called.
     */
    public function removeAll($flush = false, $iterate = true);

    /**
     * @param int        $page
     * @param int        $perPage
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return Paginator
     */
    public function findPaginatedBy($page = 1, $perPage = 10, array $criteria = [], array $orderBy = null);

    /**
     * @return int
     */
    public function countAll();

    /**
     * @return TransactionManager
     */
    public function getTransactionManager();
}
