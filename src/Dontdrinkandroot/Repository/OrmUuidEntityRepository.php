<?php

namespace Dontdrinkandroot\Repository;

class OrmUuidEntityRepository extends OrmEntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function findByUuid($uuid)
    {
        return $this->getTransactionManager()->transactional(
            function () use ($uuid) {
                $query = $this->createFindByUuidQuery($uuid);

                return $query->getOneOrNullResult();
            }
        );
    }

    protected function createFindByUuidQuery($uuid)
    {
        $queryBuilder = $this->createQueryBuilder('entity');
        $queryBuilder->where('entity.uuid = :uuid');
        $queryBuilder->setParameter('uuid', $uuid);

        return $queryBuilder->getQuery();
    }
}
