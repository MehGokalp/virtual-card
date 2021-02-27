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
        self::assertCount(2, $rates);

        /**
         * @var Rate $first
         * @var Rate $second
         */
        $first = $rates[0];
        self::assertSame('EUR', $first->getFrom());
        self::assertSame('USD', $first->getTo());
        self::assertSame(1.1026, $first->getRate());

        $second = $rates[1];
        self::assertSame('EUR', $second->getFrom());
        self::assertSame('TRY', $second->getTo());
        self::assertSame(6.5359, $second->getRate());
    }

    public function testInvalid(): void
    {
        $response = '{"EURUSD": 1.1026,"EURTRY": 6.5359},,,,';

        $this->expectException(InvalidArgumentException::class);

        CurrencyResponseParser::parse($response);
    }
}
