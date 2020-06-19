<?php

namespace VirtualCard\Tests\Vendor\Rhino\Response\Parser;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Vendor\Rhino\Response\Parser\CreateResponseParser;

class CreateResponseParserTest extends TestCase
{
    public function testValid(): void
    {
        $response = '{"number": "4506252234022455","securityCode": 290,"refCode": "THATISAREFSTRING"}';
        
        $result = CreateResponseParser::parse($response);
        
        $this->assertSame('THATISAREFSTRING', $result->getReference());
        $this->assertSame('4506252234022455', $result->getCardNumber());
        $this->assertSame('290', $result->getCvc());
    }
    
    public function testInvalid(): void
    {
        $response = '{someinvalidresponse},,';
        
        $this->expectException(InvalidArgumentException::class);
        
        CreateResponseParser::parse($response);
    }
}
