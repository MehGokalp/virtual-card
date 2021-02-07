<?php

namespace VirtualCard\Service\VirtualCard\Remove;

use VirtualCard\Entity\Vendor;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Schema\VirtualCard\Remove\Result as RemoveResult;

interface VirtualCardRemoveHandlerInterface
{
    public function handle(VirtualCard $virtualCard, Vendor $vendor): RemoveResult;
}
