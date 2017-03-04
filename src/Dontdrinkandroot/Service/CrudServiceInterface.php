<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface CrudServiceInterface
{
    public function find($id);

    public function findAll();

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
     * @param object $entity
     * @param string $fieldName
     *
     * @return object
     */
    public function createAssociation($entity, string $fieldName);

    /**
     * @param object     $entity
     * @param string     $fieldName
     * @param string|int $id
     */
    public function addAssociation($entity, string $fieldName, $id);

    /**
     * @param object          $entity
     * @param string          $fieldName
     * @param string|int|null $id
     */
    public function removeAssociation($entity, string $fieldName, $id = null);
}
