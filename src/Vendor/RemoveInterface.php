<?php

namespace VirtualCard\Vendor;

use VirtualCard\Entity\VirtualCard;
use VirtualCard\Schema\Vendor\Remove\Result as RemoveResult;

interface RemoveInterface
{
    public function getResult(VirtualCard $virtualCard): RemoveResult;
}
