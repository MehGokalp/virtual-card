<?php

namespace VirtualCard\Vendor;

use VirtualCard\Entity\VirtualCard;
use VirtualCard\Schema\Vendor\Create\Result as CreateResult;

interface CreateInterface
{
    public function getResult(array $virtualCard): CreateResult;
}
