<?php

namespace Dontdrinkandroot\Entity;

interface CreatedEntityInterface
{

    /**
     * @return \DateTime|null
     */
    public function getCreated();

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created);
}
