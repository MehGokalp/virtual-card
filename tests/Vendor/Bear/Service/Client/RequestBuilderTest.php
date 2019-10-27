<?php

namespace VirtualCard\Tests\Vendor\Bear\Service\Client;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Vendor\Bear\Service\Client\RequestBuilder;
use VirtualCard\Vendor\Bear\Service\Client\Router;

class RequestBuilderTest extends TestCase
{
    private const CREATE_MOCK_SERVICE_URL = 'https://www.mockbearcreate.io/';
    private const REMOVE_MOCK_SERVICE_URL = 'https://www.mockbearremove.io/';
    
    /**
     * @var RequestBuilder
     */
    private $builder;
    
    protected function setUp()
    {
        $this->builder = new RequestBuilder(new Router(self::CREATE_MOCK_SERVICE_URL, self::REMOVE_MOCK_SERVICE_URL));
    }
    
    public function testCreateRequest(): void
    {
        $request = $this->builder->build(VendorServiceLoader::CREATE, 'testprocess');
        
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(self::CREATE_MOCK_SERVICE_URL, $request->getUri()->__toString());
        $this->assertEquals('testprocess', $request->getHeaderLine('X-Process-Id'));
        $this->assertEquals(VendorServiceLoader::CREATE, $request->getHeaderLine('X-Method'));
        $this->assertEquals(Vendor::BEAR, $request->getHeaderLine('X-Service'));
        $this->assertEquals('gzip', $request->getHeaderLine('Accept-Encoding'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
    }
    
    public function testRemoveRequest(): void
    {
        $request = $this->builder->build(VendorServiceLoader::REMOVE, 'testprocess');
        
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(self::REMOVE_MOCK_SERVICE_URL, $request->getUri()->__toString());
        $this->assertEquals('testprocess', $request->getHeaderLine('X-Process-Id'));
        $this->assertEquals(VendorServiceLoader::REMOVE, $request->getHeaderLine('X-Method'));
        $this->assertEquals(Vendor::BEAR, $request->getHeaderLine('X-Service'));
        $this->assertEquals('gzip', $request->getHeaderLine('Accept-Encoding'));
        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
    }
    
    public function testRouteNotFound(): void
    {
        $this->expectException(RouterMethodNotFoundException::class);
        
        $this->builder->build('someinvalidroute', 'testprocess');
    }
}
