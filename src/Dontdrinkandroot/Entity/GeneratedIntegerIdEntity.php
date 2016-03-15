<?php

namespace Dontdrinkandroot\Entity;

class GeneratedIntegerIdEntity implements IntegerIdEntityInterface
{
    /** @var int */
    private $id;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isPersisted()
    {
        return null !== $this->id;
    }
}
