<?php
namespace VirtualCard\Service\VirtualCard\Create;

use VirtualCard\Entity\Vendor;
use VirtualCard\Entity\VirtualCard;
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
    use VendorServiceLoaderAware,
        ValidatorAware
    ;
    
    /**
     * This handler sends requests to vendor's web service
     * after then it processes it's response
     *
     * If you want to do something different from that
     * architecture create another handler
     *
     * @param VirtualCard $virtualCard
     * @param Vendor $vendor
     * @return CreateResult
     * @throws ValidationException
     */
    public function handle(VirtualCard $virtualCard, Vendor $vendor): CreateResult
    {
        $vendorSlug = $vendor->getSlug();
        /**
         * @var CreateInterface $service
         */
        $service = $this->vendorServiceLoader->get($vendorSlug, VendorServiceLoader::CREATE);
        
        $vendorResult = $service->getResult($virtualCard);
        
        $errors = $this->validator->validate($vendorResult);
        
        if (count($errors) > 0) {
            throw new ValidationException((string) $errors);
        }
        
        return (new CreateResult())
            ->setCardNumber($vendorResult->getCardNumber())
            ->setCvc($vendorResult->getCvv())
            ->setReference($vendorResult->getReference())
            ->setVendor($vendorSlug)
        ;
    }
}