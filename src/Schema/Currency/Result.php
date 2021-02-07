<?php

namespace VirtualCard\Schema\Currency;

class Result
{
    /**
     * @var array|Rate[]
     */
    private $rates = [];

    /**
     * @return array
     */
    public function getRates(): array
    {
        return $this->rates;
    }

    /**
     * @param array $rates
     * @return Result
     */
    public function setRates(array $rates): Result
    {
        $this->rates = $rates;

        return $this;
    }
}