<?php

namespace VirtualCard\Vendor\Rhino\Response\Parser;

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
            ->setCardNumber($parsedResponse['card_number'])
            ->setCurrency($parsedResponse['currency'])
            ->setBalance($parsedResponse['balance'])
            ->setActivationDate(new DateTime($parsedResponse['activation_date']))
            ->setExpireDate(new DateTime($parsedResponse['expire_date']));
    }
}
