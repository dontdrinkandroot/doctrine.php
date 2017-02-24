<?php

namespace Dontdrinkandroot\Repository;

use Dontdrinkandroot\Entity\UuidEntityInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UuidEntityRepositoryInterface extends EntityRepositoryInterface
{
    /**
     * @param string $uuid
     *
     * @return UuidEntityInterface|null
     */
    public function findByUuid($uuid);
}
