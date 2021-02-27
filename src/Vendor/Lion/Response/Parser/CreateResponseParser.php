<?php

namespace VirtualCard\Vendor\Lion\Response\Parser;

use DateTime;
use VirtualCard\Schema\Vendor\Create\Result;

class CreateResponseParser
{
    public static function parse(string $response): Result
    {
        $parsedResponse = \GuzzleHttp\json_decode($response, true);

        return (new Result())
            ->setReference($parsedResponse['reference'])
            ->setCvc($parsedResponse['cvc'])
            ->setCardNumber($parsedResponse['cardNumber'])
            ->setCurrency($parsedResponse['currency'])
            ->setBalance($parsedResponse['balance'])
            ->setActivationDate(new DateTime($parsedResponse['activationDate']))
            ->setExpireDate(new DateTime($parsedResponse['expireDate']));
    }
}
