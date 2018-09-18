<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface CreatedEntityInterface
{
    /**
     * @return \DateTime|null
     */
    public function getCreated(): ?\DateTime;

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created);
}