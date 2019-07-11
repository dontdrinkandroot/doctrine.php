<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Dontdrinkandroot\Entity\EntityInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class CrudRepository extends EntityRepository implements CrudRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persist(object $entity, bool $flush = true): object
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->flush($entity);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function merge(object $entity, bool $flush = false): object
    {
        $entity = $this->getEntityManager()->merge($entity);

        if ($flush) {
            $this->flush($entity);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(object $entity = null): void
    {
        $this->getEntityManager()->flush($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function detach(object $entity): void
    {
        $this->getEntityManager()->detach($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function removeById($id, bool $flush = false): void
    {
        /** @var EntityInterface $entity */
        $entity = $this->find($id);
        $this->remove($entity, $flush);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(object $entity, bool $flush = false)
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->flush($entity);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeAll(bool $flush = false, bool $iterate = true)
    {
        if ($iterate) {
            $this->removeAllByIterating();
        } else {
            $this->removeAllByQuery();
        }

        if ($flush) {
            $this->flush();
        }
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
        $queryBuilder = $this->createQueryBuilder('entity');

        foreach ($criteria as $field => $value) {
            $queryBuilder->andWhere('entity.' . $field . ' = :' . $field);
            $queryBuilder->setParameter($field, $value);
        }

        if (null !== $orderBy) {
            foreach ($orderBy as $field => $order) {
                $queryBuilder->addOrderBy('entity.' . $field, $order);
            }
        }

        $queryBuilder->setFirstResult(($page - 1) * $perPage);
        $queryBuilder->setMaxResults($perPage);

        return new Paginator($queryBuilder);
    }

    /**
     * {@inheritdoc}
     */
    public function countAll(): int
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('count(entity)')
            ->from($this->getClassName(), 'entity');

        $result = $queryBuilder->getQuery()->getSingleScalarResult();

        return $result;
    }

    protected function removeAllByIterating(int $batchSize = 100)
    {
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

    protected function removeAllByQuery()
    {
        $queryBuilder = $this->createQueryBuilder('entity');
        $queryBuilder->delete();
        $query = $queryBuilder->getQuery();
        $query->execute();
    }

    protected function createBlankQueryBuilder(): QueryBuilder
    {
        return $this->getEntityManager()->createQueryBuilder();
    }
}
