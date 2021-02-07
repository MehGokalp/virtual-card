<?php

namespace VirtualCard\Traits;

use VirtualCard\Service\VendorServiceLoader;

trait VendorServiceLoaderAware
{
    /**
     * @var VendorServiceLoader
     */
    private $vendorServiceLoader;

    /**
     * @return VendorServiceLoader
     */
    public function getVendorServiceLoader(): VendorServiceLoader
    {
        return $this->vendorServiceLoader;
    }

    /**
     * @required
     *
     * @param VendorServiceLoader $vendorServiceLoader
     * @return VendorServiceLoaderAware
     */
    public function setVendorServiceLoader(VendorServiceLoader $vendorServiceLoader): self
    {
        $this->vendorServiceLoader = $vendorServiceLoader;

        return $this;
    }
}
