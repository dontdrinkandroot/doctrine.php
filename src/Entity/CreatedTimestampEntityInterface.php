<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface CreatedTimestampEntityInterface
{
    function getCreatedTimestamp(): ?int;

    function setCreatedTimestamp(int $timestamp);
}
