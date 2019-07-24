<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UpdatedTimestampEntityInterface
{
    function getUpdatedTimestamp(): ?int;

    function setUpdatedTimestamp(int $timestamp);
}
