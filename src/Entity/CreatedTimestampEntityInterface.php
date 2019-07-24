<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface CreatedTimestampEntityInterface
{
    public function getCreatedTimestamp(): ?int;

    public function setCreatedTimestamp(int $timestamp);
}
