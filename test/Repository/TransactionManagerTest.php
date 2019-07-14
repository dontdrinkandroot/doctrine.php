<?php

namespace Dontdrinkandroot\Repository;

use Dontdrinkandroot\DoctrineOrmTestCase;
use Dontdrinkandroot\Entity\ExampleDefaultUuidEntity;
use Dontdrinkandroot\Fixtures\ExampleDefaultUuidEntities;
use Exception;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class TransactionManagerTest extends DoctrineOrmTestCase
{
    public function testCommitAndFlush()
    {
        $transactionManager = new TransactionManager($this->entityManager);
        $entity = (new ExampleDefaultUuidEntity())
            ->setName('test')
            ->setUuid(ExampleDefaultUuidEntities::UUID_1);
        $this->assertNull($entity->getId());
        $transactionManager->transactional(
            function () use ($entity) {
                $this->entityManager->persist($entity);
                $this->assertNull($entity->getId());
            }
        );
        $this->assertNotNull($entity->getId());
    }

    public function testNested()
    {
        $transactionManager = new TransactionManager($this->entityManager);
        $entity = (new ExampleDefaultUuidEntity())
            ->setName('test')
            ->setUuid(ExampleDefaultUuidEntities::UUID_1);
        $this->assertNull($entity->getId());
        $transactionManager->transactional(
            function () use ($entity, $transactionManager) {
                $transactionManager->transactional(
                    function () use ($entity) {
                        $this->entityManager->persist($entity);
                        $this->assertNull($entity->getId());
                    }
                );
                $this->assertNull($entity->getId());
            }
        );
        $this->assertNotNull($entity->getId());
    }

    public function testRollback()
    {
        $transactionManager = new TransactionManager($this->entityManager);
        $entity = (new ExampleDefaultUuidEntity())
            ->setName('test')
            ->setUuid(ExampleDefaultUuidEntities::UUID_1);
        $this->assertNull($entity->getId());
        try {
            $transactionManager->transactional(
                function () use ($entity) {
                    $this->entityManager->persist($entity);
                    $this->assertNull($entity->getId());
                    throw new Exception('Failure');
                }
            );
            $this->fail('Exception expected');
        } catch (Exception $e) {
            /* Expected */
        }
        $this->assertNull($entity->getId());
    }
}
