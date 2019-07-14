<?php

namespace Dontdrinkandroot\Repository;

use Dontdrinkandroot\DoctrineOrmTestCase;
use Dontdrinkandroot\Entity\DefaultUuidEntity;
use Dontdrinkandroot\Entity\ExampleDefaultUuidEntity;
use Dontdrinkandroot\Entity\GeneratedIdExampleEntity;
use Dontdrinkandroot\Fixtures\ExampleDefaultUuidEntities;

class TransactionalUuidCrudRepositoryTest extends DoctrineOrmTestCase
{
    /**
     * @var TransactionalUuidCrudRepository
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new TransactionalUuidCrudRepository(
            $this->entityManager,
            $this->entityManager->getClassMetadata(ExampleDefaultUuidEntity::class)
        );
    }

    public function testFindByUuid()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);

        $this->assertNull($this->repository->findByUuid('notexisting'));

        /** @var ExampleDefaultUuidEntity $entity */
        $entity = $this->repository->findByUuid(ExampleDefaultUuidEntities::UUID_2);
        $this->assertNotNull($entity);
        $this->assertEquals(ExampleDefaultUuidEntities::UUID_2, $entity->getUuid());
    }

    public function testPersist()
    {
        $entity = (new ExampleDefaultUuidEntity())
            ->setName('New Entity');

        /** @var ExampleDefaultUuidEntity $entity */
        $entity = $this->repository->persist($entity);
        $this->assertNotNull($entity->getId());

        /* Make sure listeners were called */
        $this->assertNotNull($entity->getUuid());
        $this->assertNotNull($entity->getCreated());
        $this->assertNotNull($entity->getUpdated());
    }

    public function testRemove()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);

        $entity = $this->repository->findByUuid(ExampleDefaultUuidEntities::UUID_2);

        $this->repository->remove($entity);

        $this->assertNull($this->repository->findByUuid(ExampleDefaultUuidEntities::UUID_2));
    }

    public function testRemoveById()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);

        /** @var DefaultUuidEntity $entity */
        $entity = $this->repository->findByUuid(ExampleDefaultUuidEntities::UUID_2);

        $this->repository->removeById($entity->getId());

        $this->assertNull($this->repository->findByUuid(ExampleDefaultUuidEntities::UUID_2));
    }

    public function testCountAll()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);
        $this->assertEquals(6, $this->repository->countAll());
    }

    public function testRemoveAll()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);
        $this->assertEquals(6, $this->repository->countAll());
        $this->repository->removeAll(true, false);
        $this->assertEquals(0, $this->repository->countAll());
    }

    public function testRemoveAllIterating()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);
        $this->assertEquals(6, $this->repository->countAll());
        $this->repository->removeAll(true, true);
        $this->assertEquals(0, $this->repository->countAll());
    }

    public function testFindPaginatedBy()
    {
        $this->loadFixtures([ExampleDefaultUuidEntities::class]);

        $paginator = $this->repository->findPaginatedBy(1, 4);
        $this->assertCount(4, $paginator->getIterator());
        $this->assertEquals(6, $paginator->count());

        $paginator = $this->repository->findPaginatedBy(2, 4);
        $this->assertCount(2, $paginator->getIterator());
        $this->assertEquals(6, $paginator->count());

        $paginator = $this->repository->findPaginatedBy(1, 10, ['id' => 3]);
        $this->assertCount(1, $paginator->getIterator());
        $this->assertEquals(1, $paginator->count());

        $paginator = $this->repository->findPaginatedBy(1, 10, [], ['name' => 'DESC']);
        /** @var GeneratedIdExampleEntity[] $results */
        $results = $paginator->getIterator()->getArrayCopy();
        $this->assertCount(6, $results);
        $this->assertEquals(6, $paginator->count());

        $this->assertEquals('Two', $results[0]->getName());
        $this->assertEquals('Three', $results[1]->getName());
        $this->assertEquals('Six', $results[2]->getName());
        $this->assertEquals('One', $results[3]->getName());
        $this->assertEquals('Four', $results[4]->getName());
        $this->assertEquals('Five', $results[5]->getName());
    }
}
