<?php

namespace Dontdrinkandroot\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class Group extends GeneratedIntegerIdEntity
{
    /**
     * @var Collection
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user)
    {
        $this->users->add($user);
    }
}
