<?php

namespace Dontdrinkandroot\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

interface CrudServiceInterface extends ObjectRepository
{
    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator;

    /**
     * @param object $entity
     *
     * @return object
     */
    public function create($entity);

    /**
     * @param object $entity
     *
     * @return object
     */
    public function update($entity);

    /**
     * @param object $entity
     *
     * @return object mixed
     */
    public function remove($entity);

    /**
     * @param object $entity
     * @param string $association
     * @param int    $page
     * @param int    $perPage
     */
    public function findAssociationPaginated($entity, string $association, int $page = 1, $perPage = 50);

    /**
     * @param object     $entity
     * @param string     $fieldName
     * @param string|int $id
     */
    public function addToCollection($entity, string $fieldName, $id);

    /**
     * @param object     $entity
     * @param string     $fieldName
     * @param string|int $id
     */
    public function removeFromCollection($entity, string $fieldName, $id);
}