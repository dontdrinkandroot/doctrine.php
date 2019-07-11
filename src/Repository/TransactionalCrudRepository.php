<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class TransactionalCrudRepository extends CrudRepository
{
    /**
     * @var TransactionManager
     */
    private $transactionManager;

    /**
     * @param ManagerRegistry|EntityManagerInterface $registryOrManager
     * @param string|ClassMetadata                   $classNameOrMetadata
     * @param TransactionManager|null                $transactionManager
     */
    public function __construct(
        $registryOrManager,
        $classNameOrMetadata,
        ?TransactionManager $transactionManager = null
    ) {
        parent::__construct($registryOrManager, $classNameOrMetadata);

        if (null === $transactionManager) {
            $this->transactionManager = new TransactionManager($this->getEntityManager());
        } else {
            $this->transactionManager = $transactionManager;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function persist(object $entity, bool $flush = true): object
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                return parent::persist($entity, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function merge(object $entity, $flush = false): object
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                return parent::merge($entity, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function remove(object $entity, bool $flush = false): void
    {
        $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                parent::remove($entity, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id, bool $flush = false): void
    {
        $this->transactionManager->transactional(
            function () use ($id, $flush) {
                parent::removeById($id, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll(bool $flush = false, bool $iterate = true): void
    {
        $this->transactionManager->transactional(
            function () use ($flush, $iterate) {
                parent::removeAll($flush, $iterate);
            }
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
            function () use ($page, $perPage, $criteria, $orderBy) {
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
            function () {
                return parent::countAll();
            }
        );
    }

    public function getTransactionManager()
    {
        return $this->transactionManager;
    }
}