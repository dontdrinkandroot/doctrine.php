<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\DoctrineOrmTestCase;
use Dontdrinkandroot\Entity\ExampleDefaultUuidEntity;
use Dontdrinkandroot\Fixtures\ExampleDefaultUuidEntities;
use Dontdrinkandroot\Repository\UuidCrudRepository;

class RepositoryUuidCrudServiceTest extends DoctrineOrmTestCase
{
    /**
     * @var UuidCrudServiceInterface
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new RepositoryUuidCrudService(
            new UuidCrudRepository(
                $this->entityManager,
                $this->entityManager->getClassMetadata(ExampleDefaultUuidEntity::class)
            )
        );
    }

    public function testFindAll()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);

        $entities = $this->service->findAll();
        $this->assertCount(6, $entities);
    }

    public function testCreate()
    {
        $entity = (new ExampleDefaultUuidEntity())
            ->setName('newly saved entity')
            ->setUuid('1e216c84-d4bd-4212-8a0a-de4874784227');

        /** @var ExampleDefaultUuidEntity $entity */
        $entity = $this->service->create($entity);
        $this->assertNotNull($entity->getId());

        $this->assertCount(1, $this->service->findAll());

        $refetchedEntity = $this->service->find($entity->getId());
        $this->assertNotNull($refetchedEntity);
        $this->assertEquals($entity, $refetchedEntity);
    }

    public function testUpdate()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);

        /** @var ExampleDefaultUuidEntity $entity */
        $entity = $this->service->findByUuid(ExampleDefaultUuidEntities::UUID_1);
        $this->assertEquals('One', $entity->getName());

        $entity->setName('Updated');
        $this->service->update($entity);

        /** @var ExampleDefaultUuidEntity $entity */
        $entity = $this->service->findByUuid(ExampleDefaultUuidEntities::UUID_1);
        $this->assertEquals('Updated', $entity->getName());
    }
}
