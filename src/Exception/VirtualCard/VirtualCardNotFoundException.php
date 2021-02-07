<?php

namespace VirtualCard\Exception\VirtualCard;

use Exception;
use Throwable;

class VirtualCardNotFoundException extends Exception
{

    public function __construct(string $message = 'Virtual card not found', Throwable $previous = null)
    {
        parent::__construct($message, 5e5, $previous);
    }
}
