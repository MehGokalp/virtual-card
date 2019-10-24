<?php
namespace VirtualCard\Vendor\Rhino\Service;

use VirtualCard\Entity\VirtualCard;
use VirtualCard\Schema\Vendor\Create\Result as CreateResult;
use VirtualCard\Vendor\CreateInterface;

class Create implements CreateInterface
{
    public function getResult(VirtualCard $virtualCard): CreateResult
    {
        // TODO: Implement handle() method.
    }
}
