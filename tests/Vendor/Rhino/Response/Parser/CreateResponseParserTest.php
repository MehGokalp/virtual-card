<?php

namespace VirtualCard\Tests\Vendor\Rhino\Response\Parser;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Vendor\Rhino\Response\Parser\CreateResponseParser;

class CreateResponseParserTest extends TestCase
{
    public function testValid(): void
    {
        $response = '{
    "currency": "EUR",
    "balance": 5000,
    "activation_date": "2020-03-05T00:00:00+03:00",
    "expire_date": "2020-05-04T00:00:00+03:00",
    "reference": "3zQehHpnttE6QhjQL95othas0SY5XI",
    "card_number": "6370959857439414",
    "cvc": "312"
}';

        $result = CreateResponseParser::parse($response);

        self::assertSame('3zQehHpnttE6QhjQL95othas0SY5XI', $result->getReference());
        self::assertSame('6370959857439414', $result->getCardNumber());
        self::assertSame('312', $result->getCvc());
        self::assertSame('EUR', $result->getCurrency());
        self::assertSame(5000, $result->getBalance());
        self::assertSame('2020-03-05', $result->getActivationDate()->format('Y-m-d'));
        self::assertSame('2020-05-04', $result->getExpireDate()->format('Y-m-d'));
    }

    public function testInvalid(): void
    {
        $response = '{someinvalidresponse},,';

        $this->expectException(InvalidArgumentException::class);

        CreateResponseParser::parse($response);
    }
}
