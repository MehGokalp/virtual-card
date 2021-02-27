<?php

namespace VirtualCard\Service\VirtualCard\Create;

use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Schema\VirtualCard\Create\Result as CreateResult;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Traits\ValidatorAware;
use VirtualCard\Traits\VendorServiceLoaderAware;
use VirtualCard\Vendor\CreateInterface;

use function count;

/**
 * Class VirtualCardCreateHandler
 * @package VirtualCard\Service\VirtualCard\Create
 */
class VirtualCardCreateHandler implements VirtualCardCreateHandlerInterface
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
     * @param array $virtualCard
     * @param Vendor $vendor
     * @return CreateResult
     * @throws ValidationException
     */
    public function handle(array $virtualCard, Vendor $vendor): CreateResult
    {
        $vendorSlug = $vendor->getSlug();
        /** @var CreateInterface $service */
        $service = $this->vendorServiceLoader->get($vendorSlug, VendorServiceLoader::CREATE);

        $resultDTO = $service->getResult($virtualCard);

        $errors = $this->validator->validate($resultDTO);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        return (new CreateResult())
            ->setCardNumber($resultDTO->getCardNumber())
            ->setCvc($resultDTO->getCvc())
            ->setReference($resultDTO->getReference())
            ->setCurrency($resultDTO->getCurrency())
            ->setBalance($resultDTO->getBalance())
            ->setActivationDate($resultDTO->getActivationDate())
            ->setExpireDate($resultDTO->getExpireDate())
            ->setVendor($vendorSlug);
    }
}