<?php

namespace VirtualCard\Service\Factory;

use Money\Currency;
use Money\Money;

class MoneyFactory
{
    public static function create(int $balance, string $currencyCode): Money
    {
        return new Money($balance, new Currency($currencyCode));
    }
}