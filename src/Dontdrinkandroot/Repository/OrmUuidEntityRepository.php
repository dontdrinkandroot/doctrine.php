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
                return $this->findOneBy(['uuid' => $uuid]);
            }
        );
    }
}
