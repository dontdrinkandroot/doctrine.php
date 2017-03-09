<?php

namespace Dontdrinkandroot\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class User extends DefaultUuidEntity
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var Collection
     */
    private $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }
}
