<?php

namespace Dontdrinkandroot\Service;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class AbstractService
{
    /** @var  LoggerInterface */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        if (null === $this->logger) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }
}
