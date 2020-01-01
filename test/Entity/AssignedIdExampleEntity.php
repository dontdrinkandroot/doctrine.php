<?php

namespace Dontdrinkandroot\Entity;

class AssignedIdExampleEntity extends AssignedIntegerIdEntity
{
    protected $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
