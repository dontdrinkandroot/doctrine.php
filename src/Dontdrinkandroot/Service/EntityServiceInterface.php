<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Exception\NoResultFoundException;
use Dontdrinkandroot\Pagination\PaginatedResult;
use Dontdrinkandroot\Repository\TransactionManager;

interface EntityServiceInterface
{
    /**
     * @return EntityInterface[]
     */
    public function listAll();

    /**
     * @param int $page
     * @param int $perPage
     *
     * @return PaginatedResult
     */
    public function listPaginated($page, $perPage);

    /**
     * @param mixed $id
     *
     * @return EntityInterface|null
     */
    public function findById($id);

    /**
     * @param mixed $id
     *
     * @return mixed
     *
     * @throws NoResultFoundException
     */
    public function fetchById($id);

    /**
     * @param EntityInterface $entity
     *
     * @return EntityInterface
     */
    public function save(EntityInterface $entity);

    /**
     * @param mixed $id
     */
    public function removeById($id);

    /**
     * @param EntityInterface $entity
     */
    public function remove(EntityInterface $entity);

    /**
     * Removes all entity of the corresponding type.
     */
    public function removeAll();

    /**
     * @return TransactionManager
     */
    public function getTransactionManager();

    /**
     * @return string
     */
    public function getEntityClass();
}
