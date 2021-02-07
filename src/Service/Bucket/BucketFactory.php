<?php

namespace VirtualCard\Service\Bucket;

use DateTime;
use VirtualCard\Entity\Bucket;
use VirtualCard\Entity\Currency;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Service\Factory\AbstractFactory;
use VirtualCard\Traits\ValidatorAware;

use function count;

class BucketFactory extends AbstractFactory
{
    use ValidatorAware;

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param Vendor $vendor
     * @param Currency $currency
     * @return Bucket
     *
     * @throws ValidationException
     */
    public function create(DateTime $startDate, DateTime $endDate, Vendor $vendor, Currency $currency): Bucket
    {
        $clonedStartDate = (clone $startDate)->setTime(0, 0, 0);
        $clonedEndDate = (clone $endDate)->setTime(0, 0, 0);

        $bucket = (new Bucket())
            ->setStartDate($clonedStartDate)
            ->setEndDate($clonedEndDate)
            ->setCurrency($currency)
            ->setVendor($vendor)
            ->setBalance($vendor->getBucketLimit());

        $errors = $this->validator->validate($bucket);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        return $bucket;
    }
}