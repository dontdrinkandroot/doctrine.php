<?php

namespace Dontdrinkandroot\Service;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UuidCrudServiceInterface extends CrudServiceInterface
{
    public function findByUuid(string $uuid): ?object;

    public function findByIdOrUuid($idOrUuid): ?object;
}
