<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class TransactionalCrudRepository extends CrudRepository
{
    /** @var TransactionManager */
    private $transactionManager;

    public function __construct(
        EntityManagerInterface $em,
        Mapping\ClassMetadata $class,
        ?TransactionManager $transactionManager = null
    ) {
        parent::__construct($em, $class);
        if (null === $transactionManager) {
            $this->transactionManager = new TransactionManager($this->getEntityManager());
        } else {
            $this->transactionManager = $transactionManager;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return $this->transactionManager->transactional(
            function () use ($id, $lockMode, $lockVersion) {
                return parent::find($id, $lockMode = null, $lockVersion = null);
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
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
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
     * {@inheritdoc}
     */
    public function persist(object $entity, bool $flush = true): object
    {
        return $this->transactionManager->transactional(
            function () use ($entity) {
                $this->getEntityManager()->persist($entity);

                return $entity;
            },
            $flush
        );
    }

    /**
     * {@inheritdoc}
     */
    public function merge(object $entity, $flush = false): object
    {
        return $this->transactionManager->transactional(
            function () use ($entity) {
                $this->getEntityManager()->merge($entity);
            },
            $flush
        );
    }

    /**
     * {@inheritdoc}
     */
    public function remove(object $entity, bool $flush = false): void
    {
        $this->transactionManager->transactional(
            function () use ($entity): void {
                $this->getEntityManager()->remove($entity);
            },
            $flush
        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id, bool $flush = false): void
    {
        $this->transactionManager->transactional(
            function () use ($id, $flush): void {
                $entity = $this->find($id);
                if (null !== $entity) {
                    $this->remove($entity, $flush);
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function count(array $criteria)
    {
        return $this->transactionManager->transactional(
            function () use ($criteria) {
                return parent::count($criteria);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function matching(Criteria $criteria)
    {
        return $this->transactionManager->transactional(
            function () use ($criteria) {
                return parent::matching($criteria);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll(bool $flush = false, bool $iterate = true): void
    {
        $this->transactionManager->transactional(
            function () use ($iterate): void {
                parent::removeAll(false, $iterate);
            },
            $flush
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findPaginatedBy(
        int $page = 1,
        int $perPage = 10,
        array $criteria = [],
        array $orderBy = null
    ): Paginator {
        return $this->transactionManager->transactional(
            function () use ($page, $perPage, $criteria, $orderBy): Paginator {
                return parent::findPaginatedBy($page, $perPage, $criteria, $orderBy);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function countAll(): int
    {
        return $this->transactionManager->transactional(
            function (): int {
                return parent::countAll();
            }
        );
    }

    public function getTransactionManager(): TransactionManager
    {
        return $this->transactionManager;
    }

    public function setTransactionManager(TransactionManager $transactionManager): void
    {
        $this->transactionManager = $transactionManager;
    }
}
