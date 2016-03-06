<?php

namespace Dontdrinkandroot\Entity;

class DefaultUuidEntity extends GeneratedIntegerIdEntity implements UuidEntityInterface
{
    /** @var string */
    private $uuid;

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }
}
