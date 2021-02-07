<?php

namespace VirtualCard\Tests\Library\Helper;

use MongoDate;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Library\Client\GuzzleLogProcessor;

/**
 * We're not managing the $record dataset
 * Guzzle is managing it and it provide the dataset from requests
 * As we tested the request builders (ex: \VirtualCard\Tests\Vendor\Bear\Service\Client\RequestBuilderTest)
 * We do not need to test invalid dataset cases
 *
 * Class GuzzleLogProcessorTest
 * @package VirtualCard\Tests\Library\Helper
 */
class GuzzleLogProcessorTest extends TestCase
{
    /**
     * @var GuzzleLogProcessor
     */
    private $processor;

    public function testValidRecord(): void
    {
        $record = [
            'message' => '/v2/5db20549350000a414f54e71<DELIMITER>create<DELIMITER>XYZABC<DELIMITER>bear<DELIMITER>GET /v2/5db20549350000a414f54e71 HTTP/1.1
User-Agent: GuzzleHttp/6.3.3 curl/7.54.0 PHP/7.2.1
Host: www.mocky.io
X-Method: create
X-Process-Id: XYZABC
X-Service: bear
Accept-Encoding: gzip
Accept: application/json
Content-Type: application/json<DELIMITER>HTTP/1.1 200 OK
Server: Cowboy
Connection: keep-alive
Date: Sun, 27 Oct 2019 11:38:36 GMT
Content-Type: application/json
Content-Length: 93
Via: 1.1 vegur<DELIMITER><DELIMITER>{
    "refString": "THISISAMOCKEDREFCODE",
    "cardNo": "4342558146566662",
    "cvv": 347
}<DELIMITER>200',
            'level' => 200,
            'level_name' => 'INFO',
            'channel' => 'client_logger',
        ];

        $data = call_user_func($this->processor, $record);

        self::assertSame('bear', $data['service']);
        self::assertSame('XYZABC', $data['process_id']);
        self::assertSame('create', $data['method']);
        self::assertInstanceOf(MongoDate::class, $data['date']);
        self::assertSame(
            'GET /v2/5db20549350000a414f54e71 HTTP/1.1
User-Agent: GuzzleHttp/6.3.3 curl/7.54.0 PHP/7.2.1
Host: www.mocky.io
X-Method: create
X-Process-Id: XYZABC
X-Service: bear
Accept-Encoding: gzip
Accept: application/json
Content-Type: application/json',
            $data['request_header']
        );
        self::assertSame('', $data['request']);
        self::assertSame(
            'HTTP/1.1 200 OK
Server: Cowboy
Connection: keep-alive
Date: Sun, 27 Oct 2019 11:38:36 GMT
Content-Type: application/json
Content-Length: 93
Via: 1.1 vegur',
            $data['response_header']
        );
        self::assertSame(
            '{
    "refString": "THISISAMOCKEDREFCODE",
    "cardNo": "4342558146566662",
    "cvv": 347
}',
            $data['response']
        );
        self::assertSame('200', $data['code']);
        self::assertSame(200, $data['level']);
        self::assertSame('INFO', $data['level_name']);
        self::assertSame('client_logger', $data['channel']);
    }

    protected function setUp()
    {
        $this->processor = new GuzzleLogProcessor();
    }
}
