<?php

namespace VirtualCard\Vendor\Bear\Service\Client;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Vendor\RequestBuilderInterface;

class RequestBuilder implements RequestBuilderInterface
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param string $method
     * @param string $processId
     * @param string|null $body
     * @return RequestInterface
     * @throws RouterMethodNotFoundException
     */
    public function build(string $method, string $processId, ?string $body = null): RequestInterface
    {
        $headers = [
            'X-Method' => $method,
            'X-Process-Id' => $processId,
            'X-Service' => Vendor::BEAR,
            'Accept-Encoding' => 'gzip',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        [$httpMethod, $url] = $this->router->getRoute($method);

        return new Request($httpMethod, $url, $headers, $body);
    }
}
