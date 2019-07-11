<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\NoResultException;
use Dontdrinkandroot\Entity\UuidEntityInterface;
use Dontdrinkandroot\Exception\NoResultFoundException;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 *
 * @deprecated
 */
interface UuidEntityServiceInterface extends EntityServiceInterface
{
    /**
     * @param string $uuid
     *
     * @return UuidEntityInterface|null
     */
    public function findByUuid($uuid);

    /**
     * @param string $uuid
     *
     * @return UuidEntityInterface
     *
     * @throws NoResultException
     */
    public function fetchByUuid($uuid);
}
