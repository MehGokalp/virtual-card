<?php
namespace VirtualCard\Vendor\Bear\Response\Parser;

use VirtualCard\Schema\Vendor\Create\Result;

class CreateResponseParser
{
    public static function parse(string $response): Result
    {
        $parsedResponse = \GuzzleHttp\json_decode($response, true);
        
        return (new Result())
            ->setReference($parsedResponse['refString'] ?? null)
            ->setCvv($parsedResponse['cvv'] ?? null)
            ->setCardNumber($parsedResponse['cardNo'] ?? null)
        ;
    }
}
