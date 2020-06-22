<?php

namespace VirtualCard\Exception\VirtualCard;

use Exception;
use Throwable;
use VirtualCard\Entity\VirtualCard;

class NoMatchingBucketException extends Exception
{
    /**
     * @var VirtualCard
     */
    private $virtualCard;
    
    public function __construct(VirtualCard $virtualCard, string $message = 'There is no matching bucket with requested virtual card', Throwable $previous = null)
    {
        $this->virtualCard = $virtualCard;
        parent::__construct($message, 5e2, $previous);
    }
    
    /**
     * @return VirtualCard
     */
    public function getVirtualCard(): VirtualCard
    {
        return $this->virtualCard;
    }
}
