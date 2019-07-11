<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\Tools\Pagination\Paginator;

class DelegatedCrudService implements CrudServiceInterface
{
    /**
     * @var CrudServiceInterface
     */
    private $delegate;

    public function __construct(CrudServiceInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id): ?object
    {
        return $this->delegate->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->delegate->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator
    {
        return $this->delegate->findAllPaginated($page, $perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function create(object $entity): object
    {
        return $this->delegate->create($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function update(object $entity): object
    {
        return $this->delegate->update($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(object $entity): void
    {
        $this->delegate->remove($entity);
    }

    protected function getDelegate(): CrudServiceInterface
    {
        return $this->delegate;
    }
}
