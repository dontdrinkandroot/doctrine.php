<?php

namespace Dontdrinkandroot;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

abstract class DoctrineFixtureTestCase extends TestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ReferenceRepository
     */
    private $referenceRepository;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->entityManager = $this->createEntityManager();
        $this->loadFixtures();
    }

    protected function createEntityManager()
    {
        $entityManager = EntityManager::create(
            [
                'pdo' => new \PDO('sqlite::memory:')
            ],
            $this->getConfiguration()
        );
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();

        $tool = new SchemaTool($entityManager);
        $tool->createSchema($classes);

        return $entityManager;
    }

    /**
     * @return Configuration
     */
    protected function getConfiguration()
    {
        $configuration = Setup::createConfiguration(true);

        $yamlDriver = new SimplifiedYamlDriver(
            [
                __DIR__ . '/../src/Entity' => 'Dontdrinkandroot\Entity',
                __DIR__ . '/Entity'        => 'Dontdrinkandroot\Entity'
            ]
        );
        $configuration->setMetadataDriverImpl($yamlDriver);

        return $configuration;
    }

    private function loadFixtures()
    {
        $loader = new Loader();
        $fixtures = $this->getFixtures();
        foreach ($fixtures as $fixture) {
            $instantiatedFixture = new $fixture;
            $loader->addFixture($instantiatedFixture);
        }

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());

        $this->referenceRepository = $executor->getReferenceRepository();
    }

    protected function getReference(string $name)
    {
        return $this->referenceRepository->getReference($name);
    }

    abstract protected function getFixtures(): array;
}
