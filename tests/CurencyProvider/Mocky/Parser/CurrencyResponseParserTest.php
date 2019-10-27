<?php

namespace VirtualCard\Tests\CurrencyProvider\Mocky\Parser;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\CurrencyProvider\Mocky\Parser\CurrencyResponseParser;
use VirtualCard\Schema\Currency\Rate;

class CurrencyResponseParserTest extends TestCase
{
    public function testValid(): void
    {
        $response = '{"EURUSD": 1.1026,"EURTRY": 6.5359}';
        
        $parsed = CurrencyResponseParser::parse($response);
        
        $rates = $parsed->getRates();
        $this->assertCount(2, $rates);
    
        /**
         * @var Rate $first
         * @var Rate $second
         */
        $first = $rates[0];
        $this->assertEquals('EUR', $first->getFrom());
        $this->assertEquals('USD', $first->getTo());
        $this->assertEquals(1.1026, $first->getRate());
        
        $second = $rates[1];
        $this->assertEquals('EUR', $second->getFrom());
        $this->assertEquals('TRY', $second->getTo());
        $this->assertEquals(6.5359, $second->getRate());
    }
    
    public function testInvalid(): void
    {
        $response = '{"EURUSD": 1.1026,"EURTRY": 6.5359},,,,';
    
        $this->expectException(InvalidArgumentException::class);
        
        CurrencyResponseParser::parse($response);
    }
}
