<?php

namespace Dontdrinkandroot\Repository;

use Dontdrinkandroot\Entity\UuidEntityInterface;

class OrmUuidEntityRepository extends OrmEntityRepository
{

    /**
     * @param string $uuid
     *
     * @return UuidEntityInterface|null
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
