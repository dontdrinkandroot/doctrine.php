<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Pagination\PaginatedResult;
use Dontdrinkandroot\Pagination\Pagination;

class OrmEntityRepository extends EntityRepository implements EntityRepositoryInterface
{

    protected $transactionManager;

    public function __construct($entityManager, ClassMetadata $classMetadata)
    {
        parent::__construct($entityManager, $classMetadata);
        $this->transactionManager = new TransactionManager($entityManager);
    }

    /**
     * {@inheritdoc}
     */
    public function persist($entity, $flush = true)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                $this->getEntityManager()->persist($entity);

                if ($flush) {
                    $this->getEntityManager()->flush($entity);
                }

                return $entity;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function merge($entity, $flush = false)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                $entity = $this->getEntityManager()->merge($entity);

                if ($flush) {
                    $this->getEntityManager()->flush($entity);
                }

                return $entity;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function flush($entity = null)
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function detach($entity)
    {
        $this->getEntityManager()->detach($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($entity, $flush = false)
    {
        return $this->transactionManager->transactional(
            function () use ($entity, $flush) {
                $this->getEntityManager()->remove($entity);

                if ($flush) {
                    $this->getEntityManager()->flush($entity);
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id, $flush = false)
    {
        return $this->transactionManager->transactional(
            function () use ($id, $flush) {
                /** @var EntityInterface $entity */
                $entity = $this->find($id);
                $this->remove($entity, $flush);
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll($flush = false, $iterate = true)
    {
        return $this->transactionManager->transactional(
            function () use ($flush, $iterate) {
                if ($iterate) {
                    $this->removeAllByIterating();
                } else {
                    $this->removeAllByQuery();
                }

                if ($flush) {
                    $this->getEntityManager()->flush();
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionManager()
    {
        return $this->transactionManager;
    }

    protected function removeAllByIterating($batchSize = 100)
    {
        return $this->transactionManager->transactional(
            function () use ($batchSize) {
                $entities = $this->findAll();
                $count = 0;
                foreach ($entities as $entity) {
                    $this->remove($entity, false);
                    $count++;
                    if ($count >= $batchSize) {
                        $this->getEntityManager()->flush();
                        $count = 0;
                    }
                }
            }
        );
    }

    protected function removeAllByQuery()
    {
        return $this->transactionManager->transactional(
            function () {
                $queryBuilder = $this->createQueryBuilder('entity');
                $queryBuilder->delete();
                $query = $queryBuilder->getQuery();
                $query->execute();
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function findPaginatedBy($page = 1, $perPage = 10, array $criteria = [], array $orderBy = null)
    {
        return $this->transactionManager->transactional(
            function () use ($page, $perPage, $criteria, $orderBy) {
                $persister = $this->getEntityManager()->getUnitOfWork()->getEntityPersister($this->_entityName);
                $total = $this->count($criteria);
                $results = $persister->loadAll($criteria, $orderBy, $perPage, ($page - 1) * $perPage);

                $pagination = new Pagination($page, $perPage, $total);
                $paginatedResult = new PaginatedResult($pagination, $results);

                return $paginatedResult;
            }
        );
    }

    /**
     * @param array $criteria
     *
     * @return int
     */
    private function count(array $criteria = [])
    {

        $persister = $this->getEntityManager()->getUnitOfWork()->getEntityPersister($this->_entityName);

        if (method_exists($persister, 'count')) {
            return $persister->count($criteria);
        }

        $queryBuilder = $this->createBlankQueryBuilder();
        $queryBuilder
            ->select('COUNT(entity)')
            ->from($this->getEntityName(), 'entity');

        if (count($criteria) > 0) {
            $expr = $queryBuilder->expr();
            foreach ($criteria as $field => $value) {
                $queryBuilder->andWhere($expr->eq('entity' . $field, $value));
            }
        }

        return (int)$queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function countAll()
    {
        return $this->transactionManager->transactional(
            function () {
                $queryBuilder = $this->getEntityManager()->createQueryBuilder();
                $queryBuilder
                    ->select('count(entity)')
                    ->from($this->getClassName(), 'entity');

                $result = $queryBuilder->getQuery()->getSingleScalarResult();

                return $result;
            }
        );
    }

    /**
     * @return QueryBuilder
     */
    protected function createBlankQueryBuilder()
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
}
