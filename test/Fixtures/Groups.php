<?php

namespace Dontdrinkandroot\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\Entity\Group;

class Groups extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $manager->persist($group);
        $this->addReference('group-1', $group);

        $group->addUser($this->getReference('user-2'));
        $group->addUser($this->getReference('user-3'));
        $group->addUser($this->getReference('user-4'));

        $group = new Group();
        $manager->persist($group);
        $this->addReference('group-2', $group);

        $group = new Group();
        $manager->persist($group);
        $this->addReference('group-3', $group);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    function getDependencies()
    {
        return [Users::class];
    }
}
