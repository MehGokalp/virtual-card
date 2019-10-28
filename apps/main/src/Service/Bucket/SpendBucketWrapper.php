<?php

namespace VirtualCard\Service\Bucket;

use Money\Money;
use VirtualCard\Entity\Bucket;
use VirtualCard\Library\Helper\BucketHelper;

class SpendBucketWrapper extends AbstractBucketWrapper
{
    public function canSpend(Bucket $bucket, Money $amount): bool
    {
        return BucketHelper::getBalanceAsMoney($bucket)->greaterThanOrEqual($amount);
    }
    
    public function spend(Bucket $bucket, Money $balance): Bucket
    {
        $bucketBalance = BucketHelper::getBalanceAsMoney($bucket);
        $newBalance = $bucketBalance->subtract($balance);
        
        $reducedBucket = $this->clone($bucket);
        $reducedBucket->setBalance($newBalance->getAmount());
        
        $this
            ->persist($reducedBucket)
            ->save()
        ;
        
        return $reducedBucket;
    }
}
