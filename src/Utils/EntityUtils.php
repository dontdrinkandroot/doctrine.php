<?php

namespace Dontdrinkandroot\Utils;

use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Entity\UuidHelper;
use Ramsey\Uuid\Uuid;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class EntityUtils
{
    /**
     * @deprecated
     */
    public const VALID_UUID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * @param EntityInterface[] $entities
     *
     * @return array
     */
    public static function collectIds(array $entities): array
    {
        $ids = [];
        foreach ($entities as $entity) {
            $ids[] = $entity->getId();
        }

        return $ids;
    }

    /**
     * @param $id
     *
     * @return bool
     * @deprecated Use Ramsey\Uuid::isValid instead
     *
     */
    public static function isUuid($id): bool
    {
        return Uuid::isValid($id);
    }
}
