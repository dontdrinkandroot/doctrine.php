<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\Query;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 *
 * @deprecated use UuidCrudRepository or TransactionalUuidCrudRepository instead
 */
class OrmUuidEntityRepository extends OrmEntityRepository implements UuidEntityRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByUuid(string $uuid): object
    {
        return $this->getTransactionManager()->transactional(
            function () use ($uuid) {
                $query = $this->createFindByUuidQuery($uuid);

                return $query->getOneOrNullResult();
            }
        );
    }

    protected function createFindByUuidQuery(string $uuid): Query
    {
        $queryBuilder = $this->createQueryBuilder('entity');
        $queryBuilder->where('entity.uuid = :uuid');
        $queryBuilder->setParameter('uuid', $uuid);

        return $queryBuilder->getQuery();
    }
}
