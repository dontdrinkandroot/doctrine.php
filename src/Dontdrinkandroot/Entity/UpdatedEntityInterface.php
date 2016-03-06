<?php

namespace Dontdrinkandroot\Entity;

interface UpdatedEntityInterface
{

    /**
     * @return \DateTime|null
     */
    public function getUpdated();

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated);
}
