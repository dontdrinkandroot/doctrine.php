<?php

namespace Dontdrinkandroot\Repository;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 *
 * @deprecated Use CrudRepositoryInterface instead
 */
interface EntityRepositoryInterface extends CrudRepositoryInterface
{
    /**
     * @return TransactionManager
     */
    public function getTransactionManager();
}
