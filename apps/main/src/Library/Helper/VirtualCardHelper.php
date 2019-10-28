<?php
namespace VirtualCard\Library\Helper;

use Money\Currency;
use Money\Money;
use VirtualCard\Entity\VirtualCard;

class VirtualCardHelper
{
    public static function getBalanceAsMoney(VirtualCard $virtualCard): Money
    {
        return new Money($virtualCard->getBalance(), new Currency($virtualCard->getCurrency()->getCode()));
    }
}
