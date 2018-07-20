<?php

namespace Dontdrinkandroot\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\Entity\User;

class Users extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUuid('e92747d3-c1e0-4df0-b56b-78c379646b18');
        $user->setUsername('alpha');
        $manager->persist($user);
        $this->addReference('user-1', $user);

        $user = new User();
        $user->setUuid('a475ed72-979c-48f5-af31-3fcc81a80f17');
        $user->setUsername('beta');
        $manager->persist($user);
        $this->addReference('user-2', $user);

        $user = new User();
        $user->setUuid('02cba987-65f3-48a8-bfad-74843265c2ac');
        $user->setUsername('gamma');
        $manager->persist($user);
        $this->addReference('user-3', $user);

        $user = new User();
        $user->setUuid('dc1dcf1e-62df-47a0-93e4-7a30931ec6ef');
        $user->setUsername('delta');
        $manager->persist($user);
        $this->addReference('user-4', $user);

        $user = new User();
        $user->setUuid('dab64f36-51f5-447d-b018-831f051d3020');
        $user->setUsername('epsilon');
        $manager->persist($user);
        $this->addReference('user-5', $user);

        $user = new User();
        $user->setUuid('7f76af68-d923-4812-a8c8-cbc2ac2d1728');
        $user->setUsername('zeta');
        $manager->persist($user);
        $this->addReference('user-6', $user);

        $user = new User();
        $user->setUuid('6c5d1758-59ea-4ca3-955a-a20155d28de3');
        $user->setUsername('eta');
        $manager->persist($user);
        $this->addReference('user-7', $user);

        $user = new User();
        $user->setUuid('30f61b21-7a93-4e2f-b5c5-384696d53305');
        $user->setUsername('theta');
        $manager->persist($user);
        $this->addReference('user-8', $user);

        $user = new User();
        $user->setUuid('5d20c8c1-4055-4938-9c89-f263308af512');
        $user->setUsername('iota');
        $manager->persist($user);
        $this->addReference('user-9', $user);

        $user = new User();
        $user->setUuid('f3566d3d-6b3e-4288-8e67-1ee78d439a92');
        $user->setUsername('kappa');
        $manager->persist($user);
        $this->addReference('user-10', $user);

        $manager->flush();
    }
}
