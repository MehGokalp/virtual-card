<?php

namespace VirtualCard\Tests\Library\Helper;

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
    
    protected function setUp()
    {
        $this->processor = new GuzzleLogProcessor();
    }
    
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
            'channel' => 'client_logger'
        ];
        
        $data = call_user_func($this->processor, $record);
        
        $this->assertEquals('bear', $data['service']);
        $this->assertEquals('XYZABC', $data['process_id']);
        $this->assertEquals('create', $data['method']);
        $this->assertInstanceOf(\MongoDate::class, $data['date']);
        $this->assertEquals('GET /v2/5db20549350000a414f54e71 HTTP/1.1
User-Agent: GuzzleHttp/6.3.3 curl/7.54.0 PHP/7.2.1
Host: www.mocky.io
X-Method: create
X-Process-Id: XYZABC
X-Service: bear
Accept-Encoding: gzip
Accept: application/json
Content-Type: application/json', $data['request_header']);
        $this->assertEquals('', $data['request']);
        $this->assertEquals('HTTP/1.1 200 OK
Server: Cowboy
Connection: keep-alive
Date: Sun, 27 Oct 2019 11:38:36 GMT
Content-Type: application/json
Content-Length: 93
Via: 1.1 vegur', $data['response_header']);
        $this->assertEquals('{
    "refString": "THISISAMOCKEDREFCODE",
    "cardNo": "4342558146566662",
    "cvv": 347
}', $data['response']);
        $this->assertEquals('200', $data['code']);
        $this->assertEquals(200, $data['level']);
        $this->assertEquals('INFO', $data['level_name']);
        $this->assertEquals('client_logger', $data['channel']);
    }
}
