<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\DoctrineFixtureTestCase;
use Dontdrinkandroot\Entity\User;
use Dontdrinkandroot\Fixtures\Users;

class DoctrineCrudServiceTest extends DoctrineFixtureTestCase
{
    protected function getFixtures(): array
    {
        return [Users::class];
    }

    public function testFindAll()
    {
        $service = $this->entityManager->getRepository(User::class);
        $this->assertInstanceOf(DoctrineUuidCrudService::class, $service);

        $entities = $service->findAll();
        $this->assertCount(10, $entities);
    }
}
