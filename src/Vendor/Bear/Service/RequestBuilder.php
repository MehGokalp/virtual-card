<?php
namespace VirtualCard\Vendor\Bear\Service;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;

class RequestBuilder
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
     * @return RequestInterface
     * @throws RouterMethodNotFoundException
     */
    public function build(string $method, string $processId): RequestInterface
    {
        $headers = [
            'X-Method' => $method,
            'X-Request-Id' => $processId,
            'X-Vendor' => Vendor::BEAR,
            'Accept-Encoding' => 'gzip',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    
        [$httpMethod, $url] = $this->router->getRoute($method);
    
        return new Request($httpMethod, $url, $headers);
    }
}
