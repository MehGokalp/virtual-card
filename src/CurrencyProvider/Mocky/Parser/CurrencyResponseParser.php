<?php

namespace VirtualCard\CurrencyProvider\Mocky\Parser;

use VirtualCard\Schema\Currency\Rate;
use VirtualCard\Schema\Currency\Result;

class CurrencyResponseParser
{
    public static function parse(string $response): Result
    {
        $parsedResponse = \GuzzleHttp\json_decode($response, true);

        $rates = [];
        foreach ($parsedResponse as $currencies => $rate) {
            $rates[] = new Rate(substr($currencies, 0, 3), substr($currencies, 3, 3), $rate);
        }

        return (new Result())->setRates($rates);
    }
}