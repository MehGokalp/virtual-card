<?php

namespace VirtualCard\Tests\Vendor\Lion\Response\Parser;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Vendor\Lion\Response\Parser\CreateResponseParser;

class CreateResponseParserTest extends TestCase
{
    public function testValid(): void
    {
        $response = '{
    "balance": 5000,
    "currency": "EUR",
    "activationDate": "2020-03-05",
    "expireDate": "2020-05-04",
    "reference": "de6deaf2-2a5c-4bf6-b5cd-5a389b550e0f",
    "cardNumber": "4948222124281996",
    "cvc": "509"
}';

        $result = CreateResponseParser::parse($response);

        self::assertSame('de6deaf2-2a5c-4bf6-b5cd-5a389b550e0f', $result->getReference());
        self::assertSame('4948222124281996', $result->getCardNumber());
        self::assertSame('509', $result->getCvc());
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
