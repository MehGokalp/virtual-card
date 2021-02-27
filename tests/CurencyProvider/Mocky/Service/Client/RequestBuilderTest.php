<?php

namespace VirtualCard\Tests\CurrencyProvider\Mocky\Service\Client;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\CurrencyProvider\Mocky\Service\Client\RequestBuilder;

class RequestBuilderTest extends TestCase
{
    private const MOCK_SERVICE_URL = 'https://www.mocky.io/';

    /**
     * @var RequestBuilder
     */
    private $builder;

    public function testValidRequest(): void
    {
        $request = $this->builder->build();

        self::assertSame('GET', $request->getMethod());
        self::assertSame('gzip', $request->getHeaderLine('Accept-Encoding'));
        self::assertSame('application/json', $request->getHeaderLine('Accept'));
        self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
    }

    protected function setUp()
    {
        $this->builder = new RequestBuilder(self::MOCK_SERVICE_URL);
    }
}
