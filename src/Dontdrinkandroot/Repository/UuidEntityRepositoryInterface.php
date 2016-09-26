<?php

namespace Dontdrinkandroot\Repository;

use Dontdrinkandroot\Entity\UuidEntityInterface;

interface UuidEntityRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * @param string $uuid
     *
     * @return UuidEntityInterface|null
     */
    public function findByUuid($uuid);
}
