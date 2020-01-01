<?php

namespace Dontdrinkandroot\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Dontdrinkandroot\Entity\ExampleDefaultUuidEntity;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class ExampleDefaultUuidEntities extends AbstractFixture
{
    const UUID_1 = 'b47290f6-13ec-4c78-a120-b5fa92fc1ed9';
    const UUID_2 = 'e19bc365-40f1-4448-a2f2-6f2b44dbc274';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $entity = new ExampleDefaultUuidEntity();
        $entity->setName('One');
        $entity->setUuid(self::UUID_1);
        $manager->persist($entity);

        $entity = new ExampleDefaultUuidEntity();
        $entity->setName('Two');
        $entity->setUuid(self::UUID_2);
        $manager->persist($entity);

        $entity = new ExampleDefaultUuidEntity();
        $entity->setName('Three');
        $entity->setUuid('621ae4b4-31da-433f-9d3f-65c835741eec');
        $manager->persist($entity);

        $entity = new ExampleDefaultUuidEntity();
        $entity->setName('Four');
        $entity->setUuid('30f43780-cf49-48a6-8099-b9d8532dc017');
        $manager->persist($entity);

        $entity = new ExampleDefaultUuidEntity();
        $entity->setName('Five');
        $entity->setUuid('9ab2815c-f536-4436-a491-e2dcce249c17');
        $manager->persist($entity);

        $entity = new ExampleDefaultUuidEntity();
        $entity->setName('Six');
        $entity->setUuid('030a962d-cc2d-4990-a34a-e374482df3ec');
        $manager->persist($entity);

        $manager->flush();
    }
}
