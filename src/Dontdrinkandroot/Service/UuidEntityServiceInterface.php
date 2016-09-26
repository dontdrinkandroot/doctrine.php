<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\Entity\UuidEntityInterface;
use Dontdrinkandroot\Exception\NoResultFoundException;

interface UuidEntityServiceInterface
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
