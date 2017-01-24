<?php

namespace Dontdrinkandroot\Repository;

use Doctrine\ORM\EntityManagerInterface;

class TransactionManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    public function commitTransaction(): bool
    {
        $nestingLevel = $this->entityManager->getConnection()->getTransactionNestingLevel();
        $flush = false;
        if (1 === $nestingLevel) {
            $flush = true;
            $this->entityManager->flush();
        }
        $this->entityManager->commit();

        return $flush;
    }

    public function rollbackTransaction()
    {
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
}
