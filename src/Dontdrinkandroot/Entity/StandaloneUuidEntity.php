<?php

namespace Dontdrinkandroot\Entity;

class StandaloneUuidEntity implements EntityInterface, UuidEntityInterface
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->uuid;
    }
}
