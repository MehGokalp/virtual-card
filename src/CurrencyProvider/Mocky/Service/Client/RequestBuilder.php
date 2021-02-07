<?php

namespace VirtualCard\CurrencyProvider\Mocky\Service\Client;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

class RequestBuilder
{
    /**
     * @var string
     */
    private $webServiceUrl;

    public function __construct(string $webServiceUrl)
    {
        $this->webServiceUrl = $webServiceUrl;
    }

    /**
     * @return RequestInterface
     */
    public function build(): RequestInterface
    {
        $headers = [
            'X-Service' => 'Mocky',
            'Accept-Encoding' => 'gzip',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        return new Request('GET', $this->webServiceUrl, $headers);
    }
}
