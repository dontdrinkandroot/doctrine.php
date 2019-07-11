<?php

namespace Dontdrinkandroot\Repository;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UuidCrudRepositoryInterface
{
    public function findByUuid(string $uuid): ?object;
}
