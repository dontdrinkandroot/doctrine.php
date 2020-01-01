<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UuidEntityInterface extends EntityInterface
{
    public function getUuid(): ?string;

    public function setUuid(string $uuid);
}
