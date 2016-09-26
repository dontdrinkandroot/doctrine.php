<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\Exception\NoResultFoundException;
use Dontdrinkandroot\Repository\UuidEntityRepositoryInterface;

class UuidEntityService extends EntityService
{
    public function findByUuid($uuid)
    {
        return $this->getRepository()->findByUuid($uuid);
    }

    public function fetchByUuid($uuid)
    {
        $entity = $this->findByUuid($uuid);
        if (null === $entity) {
            throw new NoResultFoundException('No entity with uuid: ' . $uuid);
        }

        return $entity;
    }

    /**
     * @return UuidEntityRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }

}
