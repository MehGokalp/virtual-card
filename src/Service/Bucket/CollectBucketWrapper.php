<?php

namespace VirtualCard\Service\Bucket;

use Money\Money;
use VirtualCard\Entity\Bucket;
use VirtualCard\Library\Helper\BucketHelper;
use VirtualCard\Service\Factory\MoneyFactory;

class CollectBucketWrapper extends AbstractBucketWrapper
{
    public function collect(Bucket $bucket, Money $balance): Bucket
    {
        $bucketBalance = MoneyFactory::create($bucket->getBalance(), $bucket->getCurrency()->getCode());
        $newBalance = $bucketBalance->add($balance);

        $reducedBucket = $this->clone($bucket);
        $reducedBucket->setBalance($newBalance->getAmount());

        $this
            ->persist($reducedBucket)
            ->save();

        return $reducedBucket;
    }
}
