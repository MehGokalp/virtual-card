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

    public function testCreateRequest(): void
    {
        $request = $this->builder->build(VendorServiceLoader::CREATE, 'testprocess');

        self::assertSame('POST', $request->getMethod());
        self::assertSame(self::CREATE_MOCK_SERVICE_URL, $request->getUri()->__toString());
        self::assertSame('testprocess', $request->getHeaderLine('X-Process-Id'));
        self::assertSame(VendorServiceLoader::CREATE, $request->getHeaderLine('X-Method'));
        self::assertSame(Vendor::BEAR, $request->getHeaderLine('X-Service'));
        self::assertSame('gzip', $request->getHeaderLine('Accept-Encoding'));
        self::assertSame('application/json', $request->getHeaderLine('Accept'));
        self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
    }

    public function testRemoveRequest(): void
    {
        $request = $this->builder->build(VendorServiceLoader::REMOVE, 'testprocess');

        self::assertSame('DELETE', $request->getMethod());
        self::assertSame(self::REMOVE_MOCK_SERVICE_URL, $request->getUri()->__toString());
        self::assertSame('testprocess', $request->getHeaderLine('X-Process-Id'));
        self::assertSame(VendorServiceLoader::REMOVE, $request->getHeaderLine('X-Method'));
        self::assertSame(Vendor::BEAR, $request->getHeaderLine('X-Service'));
        self::assertSame('gzip', $request->getHeaderLine('Accept-Encoding'));
        self::assertSame('application/json', $request->getHeaderLine('Accept'));
        self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
    }

    public function testRouteNotFound(): void
    {
        $this->expectException(RouterMethodNotFoundException::class);

        $this->builder->build('someinvalidroute', 'testprocess');
    }

    protected function setUp()
    {
        $this->builder = new RequestBuilder(new Router(self::CREATE_MOCK_SERVICE_URL, self::REMOVE_MOCK_SERVICE_URL));
    }
}
