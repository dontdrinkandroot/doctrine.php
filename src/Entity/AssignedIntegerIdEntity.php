<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class AssignedIntegerIdEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
