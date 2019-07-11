<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\NoResultException;
use Dontdrinkandroot\Exception\NoResultFoundException;
use Dontdrinkandroot\Repository\UuidEntityRepositoryInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 *
 * @deprecated
 */
class UuidEntityService extends EntityService implements UuidEntityServiceInterface
{
    public function findByUuid($uuid)
    {
        return $this->getRepository()->findByUuid($uuid);
    }

    public function fetchByUuid($uuid)
    {
        $entity = $this->findByUuid($uuid);
        if (null === $entity) {
            throw new NoResultException('No entity with uuid: ' . $uuid);
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
