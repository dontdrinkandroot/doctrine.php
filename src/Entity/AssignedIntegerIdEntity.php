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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
