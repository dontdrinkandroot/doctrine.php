<?php

namespace Dontdrinkandroot\Utils;

use Dontdrinkandroot\Entity\EntityInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class EntityUtils
{
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
}
