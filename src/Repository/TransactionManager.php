<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class TransactionManager
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->logger = new NullLogger();
    }

    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    public function commitTransaction(): bool
    {
        $nestingLevel = $this->entityManager->getConnection()->getTransactionNestingLevel();
        $flush = false;

        /* No active transaction */
        if (!$this->isInTransaction()) {
            $this->logger->warning('No active Transaction for commit');

            return $flush;
        }

        /* Topmost transaction, flush */
        if (1 === $nestingLevel) {
            $flush = true;
            $this->entityManager->flush();
        }
        $this->entityManager->commit();

        return $flush;
    }

    public function rollbackTransaction()
    {
        /* No active transaction */
        if (!$this->isInTransaction()) {
            $this->logger->warning('No active Transaction for commit');

            return;
        }

        $this->entityManager->rollback();
    }

    public function isInTransaction()
    {
        $hasTransaction = 0 !== $this->entityManager->getConnection()->getTransactionNestingLevel();

        return ($hasTransaction);
    }

    /**
     * @param callable $func
     *
     * @return mixed
     */
    public function transactional($func)
    {
        if (!is_callable($func)) {
            throw new \InvalidArgumentException('Expected argument of type "callable", got "' . gettype($func) . '"');
        }

        $this->beginTransaction();

        try {
            $return = call_user_func($func, $this);

            $this->commitTransaction();

            return $return;
        } catch (\Exception $e) {
            $this->entityManager->close();
            $this->rollbackTransaction();

            throw $e;
        }
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
