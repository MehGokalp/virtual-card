<?php

namespace VirtualCard\Tests\Vendor\Rhino\Service\Client;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Vendor\Rhino\Service\Client\Router;

class RouterTest extends TestCase
{
    private const CREATE_MOCK_SERVICE_URL = 'https://www.mockrhinoreate.io/';
    private const REMOVE_MOCK_SERVICE_URL = 'https://www.mockrhinoremove.io/';

    /**
     * @var Router
     */
    private $router;

    public function testCreateMethodRoute(): void
    {
        [$httpMethod, $url] = $this->router->getRoute(VendorServiceLoader::CREATE);

        self::assertSame('POST', $httpMethod);
        self::assertSame(self::CREATE_MOCK_SERVICE_URL, $url);
    }

    public function testRemoveMethodRoute(): void
    {
        [$httpMethod, $url] = $this->router->getRoute(VendorServiceLoader::REMOVE);

        self::assertSame('DELETE', $httpMethod);
        self::assertSame(self::REMOVE_MOCK_SERVICE_URL, $url);
    }

    public function testRouteNotFound(): void
    {
        $this->expectException(RouterMethodNotFoundException::class);

        $this->router->getRoute('someinvalidmethod');
    }

    protected function setUp()
    {
        $this->router = new Router(self::CREATE_MOCK_SERVICE_URL, self::REMOVE_MOCK_SERVICE_URL);
    }
}
