<?php
namespace VirtualCard\Service\VirtualCard\Create;

use VirtualCard\Entity\Vendor;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Schema\VirtualCard\Create\Result;

interface VirtualCardCreateHandlerInterface
{
    public function handle(VirtualCard $virtualCard, Vendor $vendor): Result;
}
