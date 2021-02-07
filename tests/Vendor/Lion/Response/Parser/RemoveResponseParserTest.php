<?php

namespace VirtualCard\Tests\Vendor\Lion\Response\Parser;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Vendor\Lion\Response\Parser\RemoveResponseParser;

class RemoveResponseParserTest extends TestCase
{
    public function testValid(): void
    {
        $response = '{"stat": 1}';

        $result = RemoveResponseParser::parse($response);

        self::assertSame(1, $result->getStatus());
    }

    public function testInvalid(): void
    {
        $response = '{someinvalidresponse},,';

        $this->expectException(InvalidArgumentException::class);

        RemoveResponseParser::parse($response);
    }
}
