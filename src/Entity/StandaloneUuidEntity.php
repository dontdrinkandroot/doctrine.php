<?php

namespace Dontdrinkandroot\Entity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class StandaloneUuidEntity implements EntityInterface, UuidEntityInterface
{
    /** @var string */
    private $uuid;

    /**
     * {@inheritdoc}
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->uuid;
    }
}
