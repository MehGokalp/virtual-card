<?php

namespace VirtualCard\Service;

use LogicException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use VirtualCard\DependencyInjection\VendorServiceExtension;
use VirtualCard\Vendor\VendorServiceInterface;

class VendorServiceLoader
{
    public const CREATE = 'create';
    public const REMOVE = 'remove';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array|VendorServiceInterface[]
     */
    private $services = [];

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $vendor
     *
     * @param string $method
     * @return VendorServiceInterface
     */
    public function get(string $vendor, string $method): VendorServiceInterface
    {
        $service = $this->load($vendor, $method);

        if ($service === null) {
            throw new LogicException(sprintf('Service "%s" not found for vendor "%s".', $method, $vendor));
        }


        return $service;
    }

    /**
     * @param string $vendor
     * @param string $method
     * @return VendorServiceInterface
     */
    private function load(string $vendor, string $method): VendorServiceInterface
    {
        #If already loaded
        if (array_key_exists($vendor, $this->services) && $this->services[$vendor] !== null && array_key_exists(
                $method,
                $this->services[$vendor]
            ) && $this->services[$vendor][$method] !== null) {
            return $this->services[$vendor][$method];
        }

        $serviceReference = sprintf(VendorServiceExtension::SERVICE_EXPRESSION, $vendor, $method);

        if ($this->container->has($serviceReference) === true) {
            /**
             * @var VendorServiceInterface $service
             */
            $service = $this->container->get($serviceReference);
            $this->services[$vendor][$method] = $service;

            return $service;
        }

        throw new LogicException(
            sprintf(
                'Service "%s" loading failed with vendor: %s. You should create a vendor service.',
                $method,
                $vendor
            )
        );
    }
}
