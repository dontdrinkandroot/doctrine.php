<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\Entity\UuidHelper;
use Dontdrinkandroot\Repository\CrudRepositoryInterface;
use Dontdrinkandroot\Repository\UuidCrudRepositoryInterface;
use Dontdrinkandroot\Utils\EntityUtils;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class RepositoryUuidCrudService extends RepositoryCrudService implements UuidCrudServiceInterface
{
    public function __construct(UuidCrudRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function findByUuid(string $uuid): ?object
    {
        return $this->getRepository()->findByUuid($uuid);
    }

    public function findByIdOrUuid($idOrUuid): ?object
    {
        if (EntityUtils::isUuid($idOrUuid)) {
            return $this->findByUuid($idOrUuid);
        }

        return $this->find($idOrUuid);
    }

    /**
     * @return UuidCrudRepositoryInterface
     */
    protected function getRepository(): CrudRepositoryInterface
    {
        return parent::getRepository();
    }
}
