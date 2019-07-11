<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\DoctrineOrmTestCase;
use Dontdrinkandroot\Entity\ExampleDefaultUuidEntity;
use Dontdrinkandroot\Fixtures\ExampleDefaultUuidEntities;
use Dontdrinkandroot\Repository\CrudRepository;

class RepositoryCrudServiceTest extends DoctrineOrmTestCase
{
    /**
     * @var RepositoryCrudService
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = new RepositoryCrudService(
            new CrudRepository(
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
}
