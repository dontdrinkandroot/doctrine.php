<?php

namespace Dontdrinkandroot\Utils;

use Dontdrinkandroot\Entity\EntityInterface;

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
