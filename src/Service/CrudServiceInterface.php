<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface CrudServiceInterface
{
    public function find($id);

    public function findAll();

    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator;

    public function create(object $entity): object;

    public function update(object $entity): object;

    public function remove(object $entity): void;

    /**
     * @param object $entity
     * @param string $association
     * @param int    $page
     * @param int    $perPage
     *
     * @return Paginator|array
     *
     * @deprecated To be removed
     */
    public function findAssociationPaginated($entity, string $association, int $page = 1, $perPage = 50);

    /**
     * @param object $entity
     * @param string $fieldName
     * @param object $associatedEntity
     *
     * @return object
     *
     * @deprecated To be removed
     */
    public function createAssociation($entity, string $fieldName, $associatedEntity);

    /**
     * @param object     $entity
     * @param string     $fieldName
     * @param string|int $id
     *
     * @deprecated To be removed
     */
    public function addAssociation($entity, string $fieldName, $id);

    /**
     * @param object          $entity
     * @param string          $fieldName
     * @param string|int|null $id
     *
     * @deprecated To be removed
     */
    public function removeAssociation($entity, string $fieldName, $id = null);
}
