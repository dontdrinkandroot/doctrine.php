<?php

namespace Dontdrinkandroot\Entity;

use DateTimeInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class ExampleDefaultUuidEntity extends DefaultUuidEntity implements CreatedEntityInterface, UpdatedEntityInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var DateTimeInterface
     */
    private $created;

    /**
     * @var DateTimeInterface
     */
    private $updated;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(DateTimeInterface $created)
    {
        $this->created = $created;
    }

    public function getUpdated(): ?DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(DateTimeInterface $updated)
    {
        $this->updated = $updated;
    }
}
