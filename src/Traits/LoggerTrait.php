<?php

namespace VirtualCard\Traits;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

trait LoggerTrait
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        if ($this->logger === null) {
            @trigger_error(sprintf('%s dependency not found. Using %s', LoggerInterface::class, NullLogger::class));

            return new NullLogger();
        }

        return $this->logger;
    }

    /**
     * @required
     *
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}
