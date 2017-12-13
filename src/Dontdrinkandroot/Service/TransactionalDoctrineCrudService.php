<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Dontdrinkandroot\Repository\TransactionManager;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class TransactionalDoctrineCrudService extends DoctrineCrudService
{
    /**
     * @var TransactionManager
     */
    private $transactionManager;

    public function __construct(EntityManager $em, $class, TransactionManager $transactionManager = null)
    {
        parent::__construct($em, $class);
        if (null !== $transactionManager) {
            $this->transactionManager = $transactionManager;
        } else {
            $this->transactionManager = new TransactionManager($em);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAllPaginated(int $page = 1, int $perPage = 50): Paginator
    {
        return $this->transactionManager->transactional(
            function () use ($page, $perPage) {
                return parent::findAllPaginated($page, $perPage);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function create($entity, bool $flush = true)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                return parent::create($entity, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function update($entity, bool $flush = false)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                return parent::update($entity, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity, bool $flush = false)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                parent::remove($entity, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findAssociationPaginated($entity, string $fieldName, int $page = 1, $perPage = 50)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $fieldName, $page, $perPage) {
                return parent::findAssociationPaginated(
                    $entity,
                    $fieldName,
                    $page,
                    $perPage
                );
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createAssociation($entity, string $fieldName, $associatedEntity)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $fieldName, $associatedEntity) {
                return parent::createAssociation($entity, $fieldName, $associatedEntity);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function addAssociation($entity, string $fieldName, $id)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $fieldName, $id) {
                parent::addAssociation($entity, $fieldName, $id);
            }

        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeAssociation($entity, string $fieldName, $id = null)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $fieldName, $id) {
                parent::removeAssociation($entity, $fieldName, $id);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->transactionManager->transactional(
            function () use ($id, $lockMode, $lockVersion) {
                return parent::find($id, $lockMode, $lockVersion);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->transactionManager->transactional(
            function () {
                return parent::findAll();
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->transactionManager->transactional(
            function () use ($criteria, $orderBy, $limit, $offset) {
                return parent::findBy($criteria, $orderBy, $limit, $offset);
            }
        );
    }

    /**
     * {@inheritdoc}
     */

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->transactionManager->transactional(
            function () use ($criteria, $orderBy) {
                return parent::findOneBy($criteria, $orderBy);
            }
        );
    }

    /**
     * @return TransactionManager
     */
    public function getTransactionManager(): TransactionManager
    {
        return $this->transactionManager;
    }
}
