<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class StandaloneUuidEntity implements EntityInterface, UuidEntityInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getId(): string
    {
        return $this->uuid;
    }
}
