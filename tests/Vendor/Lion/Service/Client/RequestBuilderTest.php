<?php

namespace VirtualCard\Tests\Vendor\Lion\Service\Client;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Vendor\Lion\Service\Client\RequestBuilder;
use VirtualCard\Vendor\Lion\Service\Client\Router;

class RequestBuilderTest extends TestCase
{
    private const CREATE_MOCK_SERVICE_URL = 'https://www.mocklioncreate.io/';
    private const REMOVE_MOCK_SERVICE_URL = 'https://www.mocklionremove.io/';
    
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
        
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame(self::CREATE_MOCK_SERVICE_URL, $request->getUri()->__toString());
        $this->assertSame('testprocess', $request->getHeaderLine('X-Process-Id'));
        $this->assertSame(VendorServiceLoader::CREATE, $request->getHeaderLine('X-Method'));
        $this->assertSame(Vendor::LION, $request->getHeaderLine('X-Service'));
        $this->assertSame('gzip', $request->getHeaderLine('Accept-Encoding'));
        $this->assertSame('application/json', $request->getHeaderLine('Accept'));
        $this->assertSame('application/json', $request->getHeaderLine('Content-Type'));
    }
    
    public function testRemoveRequest(): void
    {
        $request = $this->builder->build(VendorServiceLoader::REMOVE, 'testprocess');
        
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame(self::REMOVE_MOCK_SERVICE_URL, $request->getUri()->__toString());
        $this->assertSame('testprocess', $request->getHeaderLine('X-Process-Id'));
        $this->assertSame(VendorServiceLoader::REMOVE, $request->getHeaderLine('X-Method'));
        $this->assertSame(Vendor::LION, $request->getHeaderLine('X-Service'));
        $this->assertSame('gzip', $request->getHeaderLine('Accept-Encoding'));
        $this->assertSame('application/json', $request->getHeaderLine('Accept'));
        $this->assertSame('application/json', $request->getHeaderLine('Content-Type'));
    }
    
    public function testRouteNotFound(): void
    {
        $this->expectException(RouterMethodNotFoundException::class);
        
        $this->builder->build('someinvalidroute', 'testprocess');
    }
}
