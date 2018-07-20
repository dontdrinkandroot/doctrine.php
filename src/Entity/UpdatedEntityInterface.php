<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
interface UpdatedEntityInterface
{
    /**
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime;

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated);
}
