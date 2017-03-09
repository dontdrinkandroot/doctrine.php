<?php

namespace Dontdrinkandroot\Service;

use Dontdrinkandroot\DoctrineFixtureTestCase;
use Dontdrinkandroot\Entity\Group;
use Dontdrinkandroot\Entity\User;
use Dontdrinkandroot\Fixtures\Groups;

class DoctrineCrudServiceTest extends DoctrineFixtureTestCase
{
    protected function getFixtures(): array
    {
        return [Groups::class];
    }

    public function testFindAll()
    {
        $service = $this->entityManager->getRepository(User::class);
        $this->assertInstanceOf(DoctrineUuidCrudService::class, $service);

        $entities = $service->findAll();
        $this->assertCount(10, $entities);
    }

    public function testFindAssociationPaginated()
    {
        /** @var DoctrineCrudService $service */
        $service = $this->entityManager->getRepository(Group::class);
        $this->assertInstanceOf(DoctrineCrudService::class, $service);

        $group = $this->getReference('group-1');
        $paginator = $service->findAssociationPaginated($group, 'users');
        $this->assertCount(3, $paginator);

        /** @var User[] $users */
        $users = iterator_to_array($paginator->getIterator());
        $this->assertEquals('beta', $users[0]->getUsername());
        $this->assertEquals('delta', $users[1]->getUsername());
        $this->assertEquals('gamma', $users[2]->getUsername());
    }

    public function testFindAssociationPaginatedInverse()
    {
        /** @var DoctrineCrudService $service */
        $service = $this->entityManager->getRepository(User::class);
        $this->assertInstanceOf(DoctrineUuidCrudService::class, $service);

        $user = $this->getReference('user-2');

        $paginator = $service->findAssociationPaginated($user, 'groups');
        $this->assertCount(1, $paginator);
    }

    public function testAddAssociation()
    {
        /** @var User $user */
        $user = $this->getReference('user-10');
        /** @var Group $group */
        $group = $this->getReference('group-2');

        /** @var DoctrineCrudService $service */
        $service = $this->entityManager->getRepository(Group::class);
        $this->assertInstanceOf(DoctrineCrudService::class, $service);

        $service->addAssociation($group, 'users', $user->getId());

        $paginator = $service->findAssociationPaginated($group, 'users');
        $this->assertCount(1, $paginator);
    }
}
