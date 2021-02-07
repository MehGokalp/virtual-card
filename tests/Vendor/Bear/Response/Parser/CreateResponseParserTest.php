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

        self::assertSame('THISISAMOCKEDREFCODE', $result->getReference());
        self::assertSame('4342558146566662', $result->getCardNumber());
        self::assertSame('347', $result->getCvc());
    }

    public function testInvalid(): void
    {
        $response = '{someinvalidresponse},,';

        $this->expectException(InvalidArgumentException::class);

        CreateResponseParser::parse($response);
    }
}
