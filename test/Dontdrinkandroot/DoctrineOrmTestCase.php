<?php

namespace Dontdrinkandroot;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;

abstract class DoctrineOrmTestCase extends \PHPUnit_Extensions_Database_TestCase
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
        return Setup::createAnnotationMetadataConfiguration([realpath(__DIR__ . '/../')], true);
    }
}
