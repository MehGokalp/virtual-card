<?php

namespace VirtualCard\Service\VirtualCard\Remove;

use VirtualCard\Entity\Vendor;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Exception\VirtualCard\VirtualCardCanNotRemovedException;
use VirtualCard\Schema\VirtualCard\Remove\Result as RemoveResult;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Traits\ValidatorAware;
use VirtualCard\Traits\VendorServiceLoaderAware;
use VirtualCard\Vendor\RemoveInterface;

use function count;

class VirtualCardRemoveHandler implements VirtualCardRemoveHandlerInterface
{
    use ValidatorAware;
    use VendorServiceLoaderAware;

    /**
     * This handler sends requests to vendor's web service
     * after then it processes it's response
     *
     * If you want to do something different from that
     * architecture create another handler
     *
     * @param VirtualCard $virtualCard
     * @param Vendor $vendor
     * @return RemoveResult
     * @throws ValidationException
     * @throws VirtualCardCanNotRemovedException
     */
    public function handle(VirtualCard $virtualCard, Vendor $vendor): RemoveResult
    {
        /**
         * @var RemoveInterface $service
         */
        $service = $this->vendorServiceLoader->get($vendor->getSlug(), VendorServiceLoader::REMOVE);

        $vendorResult = $service->getResult($virtualCard);

        $errors = $this->validator->validate($vendorResult);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        // Check card is removed or not
        if ($vendorResult->getStatus() !== 1) {
            throw new VirtualCardCanNotRemovedException($virtualCard);
        }

        return (new RemoveResult())
            ->setStatus($vendorResult->getStatus());
    }
}
