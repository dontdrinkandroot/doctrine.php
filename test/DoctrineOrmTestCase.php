<?php

namespace Dontdrinkandroot;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\DbUnit\TestCase;

abstract class DoctrineOrmTestCase extends TestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * {@inheritdoc}
     */
    public function getConnection()
    {
        $this->pdo = new \PDO('sqlite::memory:');
        $config = $this->getConfiguration();
        //$config->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
        $connectionParams = [
            'pdo' => $this->pdo
        ];
        $this->entityManager = EntityManager::create($connectionParams, $config);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $tool = new SchemaTool($this->entityManager);
        $tool->createSchema($classes);

        return $this->createDefaultDBConnection($this->pdo);
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
}
