<?php

namespace VirtualCard\Exception\Http;

use Throwable;

class ServiceUnavailableHttpException extends \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
{
    public function __construct(
        $retryAfter = null,
        string $message = 'Service is currently unavailable please try again later.',
        Throwable $previous = null,
        ?int $code = 0,
        array $headers = []
    ) {
        parent::__construct($retryAfter, $message, $previous, $code, $headers);
    }
}