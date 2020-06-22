<?php

namespace VirtualCard\CurrencyProvider;

use VirtualCard\Schema\Currency\Result as CurrencyResult;

interface RateInterface
{
    public function getResult(): CurrencyResult;
}
