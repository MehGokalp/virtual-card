<?php

namespace VirtualCard\Vendor\Lion\Response\Parser;

use VirtualCard\Schema\Vendor\Create\Result;

class CreateResponseParser
{
    public static function parse(string $response): Result
    {
        $parsedResponse = \GuzzleHttp\json_decode($response, true);

        return (new Result())
            ->setReference($parsedResponse['reference'] ?? null)
            ->setCurrency($parsedResponse['currency'])
            ->setBalance($parsedResponse['balance'])
            ->setActivationDate(new \DateTime($parsedResponse['activationDate']))
            ->setExpireDate(new \DateTime($parsedResponse['expireDate']))
            ->setCardNumber($parsedResponse['cardNumber'] ?? null)
            ->setCvc($parsedResponse['cvc'] ?? null)
        ;
    }
}
