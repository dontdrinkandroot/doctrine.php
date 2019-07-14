<?php

namespace Dontdrinkandroot\Entity;

use DateTime;

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
     * @var DateTime
     */
    private $created;

    /**
     * @var DateTime
     */
    private $updated;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;
    }
}
