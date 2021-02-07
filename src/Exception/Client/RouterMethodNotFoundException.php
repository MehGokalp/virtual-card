<?php

namespace VirtualCard\Exception\Client;

use Exception;
use Throwable;

class RouterMethodNotFoundException extends Exception
{
    /**
     * @var string
     */
    private $method;

    public function __construct(
        string $method,
        string $message = 'Vendor method not found in router',
        Throwable $previous = null
    ) {
        parent::__construct($message, 5e2, $previous);
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
