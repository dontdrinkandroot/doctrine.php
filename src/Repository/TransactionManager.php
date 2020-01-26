<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class TransactionManager
{
    /** @var LoggerInterface */
    private $logger;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->logger = new NullLogger();
    }

    public function beginTransaction(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commitTransaction(bool $forceFlush = false): bool
    {
        $nestingLevel = $this->entityManager->getConnection()->getTransactionNestingLevel();

        /* No active transaction */
        if (!$this->isInTransaction()) {
            $this->logger->warning('No active Transaction for commit');

            return false;
        }

        $flushed = false;
        /* Topmost transaction, flush */
        if (1 === $nestingLevel || $forceFlush) {
            $flushed = true;
            $this->entityManager->flush();
        }
        $this->entityManager->commit();

        return $flushed;
    }

    public function rollbackTransaction(bool $closeEmOnException = true): void
    {
        /* No active transaction */
        if (!$this->isInTransaction()) {
            $this->logger->warning('No active Transaction for commit');

            return;
        }

        if ($closeEmOnException) {
            $this->entityManager->close();
        }
        $this->entityManager->rollback();
    }

    public function isInTransaction(): bool
    {
        return 0 !== $this->entityManager->getConnection()->getTransactionNestingLevel();
    }

    public function transactional(Callable $func, bool $forceFlush = false, bool $closeEmOnException = true)
    {
        if (!is_callable($func)) {
            throw new InvalidArgumentException('Expected argument of type "callable", got "' . gettype($func) . '"');
        }

        $this->beginTransaction();

        try {
            $return = call_user_func($func, $this);

            $this->commitTransaction($forceFlush);

            return $return;
        } catch (Exception $e) {
            $this->rollbackTransaction($closeEmOnException);

            throw $e;
        }
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
