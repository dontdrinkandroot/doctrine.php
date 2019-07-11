<?php

namespace Dontdrinkandroot\Utils;

use Dontdrinkandroot\Entity\EntityInterface;
use Dontdrinkandroot\Entity\UuidHelper;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class EntityUtils
{
    public const VALID_UUID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * @param EntityInterface[] $entities
     *
     * @return array
     */
    public static function collectIds(array $entities)
    {
        $ids = [];
        foreach ($entities as $entity) {
            $ids[] = $entity->getId();
        }

        return $ids;
    }

    public static function isUuid($id)
    {
        return 1 === preg_match('/' . self::VALID_UUID_PATTERN . '/', $id);
    }
}
