<?php
namespace VirtualCard\Vendor\Rhino\Response\Parser;

use VirtualCard\Schema\Vendor\Create\Result;

class CreateResponseParser
{
    public static function parse(string $response): Result
    {
        $parsedResponse = \GuzzleHttp\json_decode($response, true);
        
        return (new Result())
            ->setReference($parsedResponse['refCode'] ?? null)
            ->setCvv($parsedResponse['securityCode'] ?? null)
            ->setCardNumber($parsedResponse['number'] ?? null)
        ;
    }
}
