<?php

namespace VirtualCard\Vendor\Rhino\Service\Client;

use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Service\VendorServiceLoader;

class Router
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
     * @param string $method
     * @return array
     * @throws RouterMethodNotFoundException
     */
    public function getRoute(string $method): array
    {
        if ($method === VendorServiceLoader::CREATE) {
            return [ 'GET', $this->webServiceUrl ];
        }
        
        throw new RouterMethodNotFoundException($method);
    }
}
