<?php
namespace VirtualCard\Vendor\Lion\Response\Parser;

use VirtualCard\Schema\Vendor\Create\Result;

class CreateResponseParser
{
    public static function parse(string $response): Result
    {
        $parsedResponse = \GuzzleHttp\json_decode($response, true);
        
        return (new Result())
            ->setReference($parsedResponse['referenceCode'] ?? null)
            ->setCvv($parsedResponse['cvc'] ?? null)
            ->setCardNumber($parsedResponse['cardNumber'] ?? null)
        ;
    }
}
