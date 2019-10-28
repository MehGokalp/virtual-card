<?php
namespace VirtualCard\Library\Helper;

use Money\Currency;
use Money\Money;
use VirtualCard\Entity\Bucket;

class BucketHelper
{
    public static function getBalanceAsMoney(Bucket $bucket): Money
    {
        return new Money($bucket->getBalance(), new Currency($bucket->getCurrency()->getCode()));
    }
}
