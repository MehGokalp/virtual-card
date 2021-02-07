<?php

namespace VirtualCard\Service\Bucket;

use VirtualCard\Entity\Bucket;
use VirtualCard\Traits\EntityManagerAware;

abstract class AbstractBucketWrapper
{
    use EntityManagerAware;

    protected function clone(Bucket $bucket): Bucket
    {
        $cloned = clone $bucket;

        $cloned->setParent($bucket);
        $bucket->setExpired(true);

        // If base is null (means: it's base bucket)
        // Set base bucket
        if ($cloned->getBase() === null) {
            $cloned->setBase($bucket);
        }

        return $cloned;
    }

    protected function persist(Bucket $bucket): self
    {
        $this->entityManager->persist($bucket);

        return $this;
    }

    protected function save(): self
    {
        $this->entityManager->flush();

        return $this;
    }
}
