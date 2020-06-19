<?php

namespace VirtualCard\Tests\Vendor\Bear\Response\Parser;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Vendor\Bear\Response\Parser\CreateResponseParser;

class CreateResponseParserTest extends TestCase
{
    public function testValid(): void
    {
        $response = '{"refString": "THISISAMOCKEDREFCODE","cardNo": "4342558146566662","cvv": 347}';
        
        $result = CreateResponseParser::parse($response);
        
        $this->assertSame('THISISAMOCKEDREFCODE', $result->getReference());
        $this->assertSame('4342558146566662', $result->getCardNumber());
        $this->assertSame('347', $result->getCvc());
    }
    
    public function testInvalid(): void
    {
        $response = '{someinvalidresponse},,';
        
        $this->expectException(InvalidArgumentException::class);
    
        CreateResponseParser::parse($response);
    }
}
