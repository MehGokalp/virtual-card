<?php

namespace VirtualCard\Service\Bucket;

use Money\Money;
use VirtualCard\Entity\Bucket;
use VirtualCard\Service\Factory\MoneyFactory;

class SpendBucketWrapper extends AbstractBucketWrapper
{
    public function canSpend(Bucket $bucket, Money $amount): bool
    {
        return MoneyFactory::create($bucket->getBalance(), $bucket->getCurrency()->getCode())->greaterThanOrEqual(
            $amount
        );
    }

    public function spend(Bucket $bucket, Money $balance): Bucket
    {
        $bucketBalance = MoneyFactory::create($bucket->getBalance(), $bucket->getCurrency()->getCode());
        $newBalance = $bucketBalance->subtract($balance);

        $reducedBucket = $this->clone($bucket);
        $reducedBucket->setBalance($newBalance->getAmount());

        $this
            ->persist($reducedBucket)
            ->save();

        return $reducedBucket;
    }
}
