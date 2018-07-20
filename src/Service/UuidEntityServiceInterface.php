<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\Entity\UuidEntityInterface;
use Dontdrinkandroot\Exception\NoResultFoundException;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
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
     * @throws NoResultFoundException
     */
    public function fetchByUuid($uuid);
}
