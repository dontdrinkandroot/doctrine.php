<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @author     Philip Washington Sorst <philip@sorst.net>
 *
 * @deprecated Use TransactionalCrudRepository or CrudRepository instead
 */
class OrmEntityRepository extends TransactionalCrudRepository implements EntityRepositoryInterface
{
    protected $transactionManager;

    /**
     * @param ManagerRegistry|EntityManagerInterface $registryOrManager
     * @param string|ClassMetadata                   $classNameOrMetadata
     * @param TransactionManager|null                $transactionManager
     */
    public function __construct(
        $registryOrManager,
        $classNameOrMetadata,
        ?TransactionManager $transactionManager = null
    ) {
        parent::__construct($registryOrManager, $classNameOrMetadata, $transactionManager);
    }
}
