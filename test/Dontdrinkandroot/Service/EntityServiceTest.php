<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\DoctrineOrmTestCase;
use Dontdrinkandroot\Entity\AssignedIdExampleEntity;
use Dontdrinkandroot\Entity\GeneratedIdExampleEntity;
use Dontdrinkandroot\Repository\AssignedIdExampleEntityRepository;
use Dontdrinkandroot\Repository\GeneratedIdExampleEntityRepository;

class EntityServiceTest extends DoctrineOrmTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getDataSet()
    {
        return $this->createXMLDataSet(realpath(__DIR__ . '/../Repository/dataset.xml'));
    }

    public function testFindAll()
    {
        $entityService = $this->getEntityService();
        $entities = $entityService->listAll();
        $this->assertCount(3, $entities);
    }

    public function testSave()
    {
        $entityService = $this->getEntityService();

        $entity = new GeneratedIdExampleEntity();
        $entity->setName('newly saved entity');

        $entity = $entityService->save($entity);
        $this->assertNotNull($entity->getId());

        $this->assertCount(4, $entityService->listAll());

        $refetchedEntity = $entityService->fetchById($entity->getId());
        $this->assertNotNull($refetchedEntity);
        $this->assertEquals($entity, $refetchedEntity);
    }

    /**
     * @return EntityService
     */
    protected function getEntityService()
    {
        return new EntityService($this->getGeneratedIdExampleEntityRepository());
    }

    /**
     * @return GeneratedIdExampleEntityRepository
     */
    protected function getGeneratedIdExampleEntityRepository()
    {
        return $this->entityManager->getRepository(GeneratedIdExampleEntity::class);
    }

    /**
     * @return AssignedIdExampleEntityRepository
     */
    protected function getAssignedIdExampleEntityRepository()
    {
        return $this->entityManager->getRepository(AssignedIdExampleEntity::class);
    }
}
