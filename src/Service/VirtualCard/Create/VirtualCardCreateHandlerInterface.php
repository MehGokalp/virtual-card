<?php

namespace VirtualCard\Service\VirtualCard\Create;

use VirtualCard\Entity\Vendor;
use VirtualCard\Schema\VirtualCard\Create\Result;

interface VirtualCardCreateHandlerInterface
{
    public function handle(array $virtualCard, Vendor $vendor): Result;
}
