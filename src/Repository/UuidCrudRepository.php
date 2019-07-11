<?php

namespace Dontdrinkandroot\Repository;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class UuidCrudRepository extends CrudRepository implements UuidCrudRepositoryInterface
{
    public function findByUuid(string $uuid): ?object
    {
        $query = $this->createFindByUuidQuery($uuid);

        return $query->getOneOrNullResult();
    }

    protected function createFindByUuidQuery($uuid)
    {
        $queryBuilder = $this->createQueryBuilder('entity');
        $queryBuilder->where('entity.uuid = :uuid');
        $queryBuilder->setParameter('uuid', $uuid);

        return $queryBuilder->getQuery();
    }
}
