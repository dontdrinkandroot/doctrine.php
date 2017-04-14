<?php

namespace Dontdrinkandroot\Service;

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
    public function find($id)
    {
        return $this->delegate->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->delegate->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findAllPaginated(int $page = 1, int $perPage = 50)
    {
        return $this->delegate->findAllPaginated($page, $perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function create($entity)
    {
        return $this->delegate->create($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity)
    {
        return $this->delegate->update($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity)
    {
        $this->delegate->remove($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function findAssociationPaginated($entity, string $association, int $page = 1, $perPage = 50)
    {
        return $this->delegate->findAssociationPaginated($entity, $association, $page, $perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function createAssociation($entity, string $fieldName)
    {
        return $this->delegate->createAssociation($entity, $fieldName);
    }

    /**
     * {@inheritdoc}
     */
    public function addAssociation($entity, string $fieldName, $id)
    {
        $this->delegate->addAssociation($entity, $fieldName, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAssociation($entity, string $fieldName, $id = null)
    {
        $this->delegate->removeAssociation($entity, $fieldName, $id);
    }

    /**
     * @return CrudServiceInterface
     */
    protected function getDelegate()
    {
        return $this->delegate;
    }
}
