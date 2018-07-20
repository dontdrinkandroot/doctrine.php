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
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
    }
}
