<?php

namespace VirtualCard\Vendor\Lion\Service\Client;

use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Service\VendorServiceLoader;

class Router
{
    /**
     * @var string
     */
    private $createWebServiceUrl;
    
    /**
     * @var string
     */
    private $removeWebServiceUrl;
    
    public function __construct(string $createWebServiceUrl, string $removeWebServiceUrl)
    {
        $this->createWebServiceUrl = $createWebServiceUrl;
        $this->removeWebServiceUrl = $removeWebServiceUrl;
    }
    
    /**
     * @param string $method
     * @return array
     * @throws RouterMethodNotFoundException
     */
    public function getRoute(string $method): array
    {
        if ($method === VendorServiceLoader::CREATE) {
            return [ 'GET', $this->createWebServiceUrl ];
        }
        
        if ($method === VendorServiceLoader::REMOVE) {
            return [ 'GET', $this->removeWebServiceUrl ];
        }
        
        throw new RouterMethodNotFoundException($method);
    }
}
