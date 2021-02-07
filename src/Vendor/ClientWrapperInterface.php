<?php

namespace VirtualCard\Vendor;

use Psr\Http\Message\ResponseInterface;

interface ClientWrapperInterface
{
    public function request(string $method, ?string $body, string $processId, array $options = []): ResponseInterface;
}
