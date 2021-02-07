<?php

namespace VirtualCard\Exception\VirtualCard;

use Exception;
use Throwable;
use VirtualCard\Entity\VirtualCard;

class VirtualCardCanNotRemovedException extends Exception
{
    /**
     * @var VirtualCard
     */
    private $virtualCard;

    public function __construct(
        VirtualCard $virtualCard,
        string $message = 'Virtual card can not removed',
        Throwable $previous = null
    ) {
        $this->virtualCard = $virtualCard;
        parent::__construct($message, 5e4, $previous);
    }

    /**
     * @return VirtualCard
     */
    public function getVirtualCard(): VirtualCard
    {
        return $this->virtualCard;
    }
}
