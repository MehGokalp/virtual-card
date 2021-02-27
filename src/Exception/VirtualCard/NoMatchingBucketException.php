<?php

namespace VirtualCard\Exception\VirtualCard;

use Exception;
use Throwable;

class NoMatchingBucketException extends Exception
{
    /** @var array */
    private $virtualCard;

    public function __construct(
        array $virtualCard,
        string $message = 'There is no matching bucket with requested virtual card',
        Throwable $previous = null
    ) {
        $this->virtualCard = $virtualCard;
        parent::__construct($message, 5e2, $previous);
    }

    public function getVirtualCard(): array
    {
        return $this->virtualCard;
    }
}
