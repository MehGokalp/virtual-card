<?php

namespace VirtualCard\DependencyInjection;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class VendorServiceExtension extends Extension
{
    public const ALIAS = 'vendor_config';
    public const SERVICE_EXPRESSION = 'vendor_service.%s.%s';

    public function load(array $configs, ContainerBuilder $container)
    {
        foreach ($configs[0] as $vendor => $vendorServices) {
            foreach ($vendorServices as $serviceKey => $service) {
                //Set an public alias to private vendor service with format: vendor_service.%s.%s
                //Example: vendor_service.bear.create
                $aliasName = sprintf(self::SERVICE_EXPRESSION, $vendor, $serviceKey);

                $alias = (new Alias($service))
                    ->setPublic(true);

                $container->setAlias($aliasName, $alias);
            }
        }
    }

    public function getAlias()
    {
        return self::ALIAS;
    }
}