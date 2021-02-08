<?php

namespace VirtualCard\Vendor\Lion\Service\Client;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Vendor\RequestBuilderInterface;

class RequestBuilder implements RequestBuilderInterface
{
    /** @var Router */
    private $router;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    public function __construct(Router $router, string $username, string $password)
    {
        $this->router = $router;
        $this->username = $username;
        $this->password = $password;
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
            'X-Service' => Vendor::LION,
            'Accept-Encoding' => 'gzip',
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => sprintf('Basic %s', base64_encode(sprintf('%s:%s', $this->username, $this->password))),
        ];

        [$httpMethod, $url] = $this->router->getRoute($method);

        return new Request($httpMethod, $url, $headers, $body);
    }
}
