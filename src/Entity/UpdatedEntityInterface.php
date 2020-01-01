<?php

namespace Dontdrinkandroot\Entity;

use DateTimeInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UpdatedEntityInterface
{
    public function getUpdated(): ?DateTimeInterface;

    public function setUpdated(DateTimeInterface $updated);
}
