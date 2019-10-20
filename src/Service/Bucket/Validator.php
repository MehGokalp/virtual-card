<?php
namespace VirtualCard\Service\Bucket;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use VirtualCard\Entity\Bucket;

class Validator
{
    public static function validate(Bucket $bucket, ExecutionContextInterface $context): void
    {
        // We checked start date and vendor's existence before do not need to check twice
        $dateDelta = $bucket->getStartDate()->diff($bucket->getEndDate())->days;
        $vendorDateDelta = $bucket->getVendor()->getBucketDateDelta();
        if ($dateDelta !== $vendorDateDelta) {
            $context->addViolation(sprintf('Bucket\'s date delta must be same with vendor\'s delta. Expecting: %d, get: %d', $vendorDateDelta, $dateDelta));
        }
    }
}
