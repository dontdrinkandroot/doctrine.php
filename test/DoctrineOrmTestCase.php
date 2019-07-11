<?php

namespace Dontdrinkandroot;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PDO;
use PHPUnit\Framework\TestCase;

abstract class DoctrineOrmTestCase extends TestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $config = $this->getConfiguration();
        //$config->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        $connectionParams = [
            'pdo' => $this->pdo
        ];
        $this->entityManager = EntityManager::create($connectionParams, $config);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $tool = new SchemaTool($this->entityManager);
        $tool->createSchema($classes);
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

    protected function loadFixtures(array $fixtureClasses = []): ReferenceRepository
    {
        $loader = new Loader();
        foreach ($fixtureClasses as $fixtureClass) {
            $fixture = new $fixtureClass;
            $loader->addFixture($fixture);
        }

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());

        return $executor->getReferenceRepository();
    }
}
