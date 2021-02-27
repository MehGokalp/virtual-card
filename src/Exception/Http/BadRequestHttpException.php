<?php


namespace VirtualCard\Exception\Http;


use Throwable;

class BadRequestHttpException extends \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
{
    public function __construct(
        string $message = 'Your data that you sent is not valid.',
        Throwable $previous = null,
        int $code = 0,
        array $headers = []
    ) {
        parent::__construct($message, $previous, $code, $headers);
    }
}