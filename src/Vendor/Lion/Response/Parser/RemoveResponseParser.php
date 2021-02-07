<?php

namespace VirtualCard\Vendor\Lion\Response\Parser;

use VirtualCard\Schema\Vendor\Remove\Result;

class RemoveResponseParser
{
    public static function parse(string $response): Result
    {
        $parsedResponse = \GuzzleHttp\json_decode($response, true);

        return (new Result())
            ->setStatus(($parsedResponse['stat'] ?? 0) === 1);
    }
}
