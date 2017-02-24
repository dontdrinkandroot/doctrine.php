<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UuidEntityInterface extends EntityInterface
{
    const VALID_UUID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * @return string
     */
    public function getUuid();

    /**
     * @param string $uuid
     */
    public function setUuid($uuid);
}
