<?php

namespace VirtualCard\Exception;

class ValidationException extends \Exception
{
    public function __construct($message = '', \Throwable $previous = null)
    {
        parent::__construct($message, 5e1, $previous);
    }
}
