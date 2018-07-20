<?php

namespace Dontdrinkandroot\Service;

use Doctrine\ORM\EntityManagerInterface;
use Dontdrinkandroot\Repository\TransactionManager;

/**
 * Quick'n'Dirty Proxy.
 *
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class SimpleTransactionalProxy
{
    private $service;

    /**
     * @var TransactionManager
     */
    private $transactionManager;

    public function __construct($service, EntityManagerInterface $entityManager)
    {
        $this->service = $service;
        $this->transactionManager = new TransactionManager($entityManager);
    }

    public function __call($method, $args)
    {
        $callback = [$this->service, $method];

        return $this->transactionManager->transactional(
            function () use ($callback, $args) {
                return call_user_func_array($callback, $args);
            }
        );
    }
}
