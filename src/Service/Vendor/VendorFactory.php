<?php

namespace VirtualCard\Service\Vendor;

use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Service\Factory\AbstractFactory;
use VirtualCard\Traits\ValidatorAware;

class VendorFactory extends AbstractFactory
{
    use ValidatorAware;

    /**
     * @param string $slug
     * @param int $bucketDateDelta
     * @param int $bucketLimit
     * @return Vendor
     *
     * @throws ValidationException
     */
    public function create(string $slug, int $bucketDateDelta, int $bucketLimit): Vendor
    {
        $vendor = new Vendor();

        $vendor
            ->setSlug($slug)
            ->setBucketDateDelta($bucketDateDelta)
            ->setBucketLimit($bucketLimit);

        $errors = $this->validator->validate($vendor);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        return $vendor;
    }
}
