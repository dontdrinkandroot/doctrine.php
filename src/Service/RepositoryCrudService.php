<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Dontdrinkandroot\Repository\CrudRepositoryInterface;
use RuntimeException;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class RepositoryCrudService implements CrudServiceInterface
{
    /**
     * @var CrudRepositoryInterface
     */
    private $repository;

    public function __construct(CrudRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id): ?object
    {
        return $this->getRepository()->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator
    {
        return $this->getRepository()->findPaginatedBy($page, $perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function create(object $entity): object
    {
        return $this->getRepository()->persist($entity, true);
    }

    /**
     * {@inheritdoc}
     */
    public function update(object $entity): object
    {
        $this->getRepository()->flush($entity);

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(object $entity): void
    {
        $this->getRepository()->remove($entity, true);
    }

    /**
     * {@inheritdoc}
     */
    public function findAssociationPaginated($entity, string $association, int $page = 1, $perPage = 50)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function createAssociation($entity, string $fieldName, $associatedEntity)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function addAssociation($entity, string $fieldName, $id)
    {
        throw new RuntimeException('Not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function removeAssociation($entity, string $fieldName, $id = null)
    {
        throw new RuntimeException('Not implemented');
    }

    protected function getRepository(): CrudRepositoryInterface
    {
        return $this->repository;
    }
}
