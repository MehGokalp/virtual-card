<?php
namespace VirtualCard\Vendor\Rhino\Service;

use VirtualCard\Entity\VirtualCard;
use VirtualCard\Schema\Vendor\Create\Result as CreateResult;
use VirtualCard\Vendor\CreateInterface;
use VirtualCard\Vendor\VendorServiceInterface;

class Create implements CreateInterface, VendorServiceInterface
{
    public function getResult(VirtualCard $virtualCard): CreateResult
    {
        // TODO: Implement handle() method.
    }
}
