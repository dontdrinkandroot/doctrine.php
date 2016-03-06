<?php

namespace Dontdrinkandroot\Entity;

interface IntegerIdEntityInterface extends EntityInterface
{

    /**
     * @return int
     */
    public function getId();
}
