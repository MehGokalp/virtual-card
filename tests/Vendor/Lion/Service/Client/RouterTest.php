<?php

namespace VirtualCard\Tests\Vendor\Lion\Service\Client;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Vendor\Lion\Service\Client\Router;

class RouterTest extends TestCase
{
    private const CREATE_MOCK_SERVICE_URL = 'https://www.mocklionreate.io/';
    private const REMOVE_MOCK_SERVICE_URL = 'https://www.mocklionremove.io/';
    
    /**
     * @var Router
     */
    private $router;
    
    protected function setUp()
    {
        $this->router = new Router(self::CREATE_MOCK_SERVICE_URL, self::REMOVE_MOCK_SERVICE_URL);
    }
    
    public function testCreateMethodRoute(): void
    {
        [ $httpMethod, $url ] = $this->router->getRoute(VendorServiceLoader::CREATE);
        
        $this->assertEquals('GET', $httpMethod);
        $this->assertEquals(self::CREATE_MOCK_SERVICE_URL, $url);
    }
    
    public function testRemoveMethodRoute(): void
    {
        [ $httpMethod, $url ] = $this->router->getRoute(VendorServiceLoader::REMOVE);
        
        $this->assertEquals('GET', $httpMethod);
        $this->assertEquals(self::REMOVE_MOCK_SERVICE_URL, $url);
    }
    
    public function testRouteNotFound(): void
    {
        $this->expectException(RouterMethodNotFoundException::class);
        
        $this->router->getRoute('someinvalidmethod');
    }
}
