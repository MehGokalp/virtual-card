<?php

namespace VirtualCard\Tests\Vendor\Bear\Response\Parser;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Vendor\Bear\Response\Parser\CreateResponseParser;

class CreateResponseParserTest extends TestCase
{
    public function testValid(): void
    {
        $response = '{
  "currency": "TRY",
  "balance": 100000,
  "activationDate": "2021-09-20T00:00:00.000Z",
  "expireDate": "2021-09-21T00:00:00.000Z",
  "reference": "g2pc0fvjklny69o",
  "cardNumber": "5440898806537837",
  "cvc": "743"
}';

        $result = CreateResponseParser::parse($response);

        self::assertSame('g2pc0fvjklny69o', $result->getReference());
        self::assertSame('5440898806537837', $result->getCardNumber());
        self::assertSame('743', $result->getCvc());
        self::assertSame('TRY', $result->getCurrency());
        self::assertSame(100000, $result->getBalance());
        self::assertSame('2021-09-20', $result->getActivationDate()->format('Y-m-d'));
        self::assertSame('2021-09-21', $result->getExpireDate()->format('Y-m-d'));
    }

    public function testInvalid(): void
    {
        $response = '{someinvalidresponse},,';

        $this->expectException(InvalidArgumentException::class);

        CreateResponseParser::parse($response);
    }
}
