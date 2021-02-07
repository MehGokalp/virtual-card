<?php

namespace VirtualCard\Service\VirtualCard;

use Money\Money;
use VirtualCard\Service\Currency\CurrencyWrapper;
use VirtualCard\Service\Factory\MoneyFactory;

class AbstractVirtualCardWrapper
{
    /** @var CurrencyWrapper */
    protected $currencyWrapper;

    protected function getBalance(array $virtualCard): Money
    {
        return MoneyFactory::create($virtualCard['balance'], $virtualCard['currency']->getCode());
    }

    /**
     * @required
     *
     * @param CurrencyWrapper $currencyWrapper
     */
    public function setCurrencyWrapper(CurrencyWrapper $currencyWrapper): void
    {
        $this->currencyWrapper = $currencyWrapper;
    }
}