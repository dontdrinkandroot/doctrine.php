<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class DefaultUuidEntity extends GeneratedIntegerIdEntity implements UuidEntityInterface
{
    /**
     * @var string
     */
    private $uuid;

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
