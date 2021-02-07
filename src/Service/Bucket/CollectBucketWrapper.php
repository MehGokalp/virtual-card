<?php

namespace VirtualCard\Service\Bucket;

use Money\Money;
use VirtualCard\Entity\Bucket;
use VirtualCard\Library\Helper\BucketHelper;

class CollectBucketWrapper extends AbstractBucketWrapper
{
    public function collect(Bucket $bucket, Money $balance): Bucket
    {
        $bucketBalance = BucketHelper::getBalanceAsMoney($bucket);
        $newBalance = $bucketBalance->add($balance);

        $reducedBucket = $this->clone($bucket);
        $reducedBucket->setBalance($newBalance->getAmount());

        $this
            ->persist($reducedBucket)
            ->save();

        return $reducedBucket;
    }
}
