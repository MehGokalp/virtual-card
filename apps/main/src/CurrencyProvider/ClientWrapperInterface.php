<?php

namespace VirtualCard\CurrencyProvider;

use Psr\Http\Message\ResponseInterface;

interface ClientWrapperInterface
{
    public function request(array $options = []): ResponseInterface;
}
