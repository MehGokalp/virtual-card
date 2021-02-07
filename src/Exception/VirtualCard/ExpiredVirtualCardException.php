<?php

namespace VirtualCard\Exception\VirtualCard;

use Exception;
use Throwable;
use VirtualCard\Entity\VirtualCard;

class ExpiredVirtualCardException extends Exception
{
    /**
     * @var VirtualCard
     */
    private $virtualCard;

    public function __construct(
        VirtualCard $virtualCard,
        string $message = 'Expired virtual card',
        Throwable $previous = null
    ) {
        $this->virtualCard = $virtualCard;
        parent::__construct($message, 5e3, $previous);
    }

    /**
     * @return VirtualCard
     */
    public function getVirtualCard(): VirtualCard
    {
        return $this->virtualCard;
    }
}
