<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UuidEntityInterface extends EntityInterface
{
    /**
     * @return string
     */
    public function getUuid(): ?string;

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid);
}
