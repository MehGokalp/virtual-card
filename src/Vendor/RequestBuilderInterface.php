<?php

namespace VirtualCard\Vendor;

use Psr\Http\Message\RequestInterface;

interface RequestBuilderInterface
{
    public function build(string $method, string $processId, ?string $body = null): RequestInterface;
}