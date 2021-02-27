<?php

namespace VirtualCard\Tests\Service;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use VirtualCard\DependencyInjection\VendorServiceExtension;
use VirtualCard\Service\VendorServiceLoader;

class VendorServiceLoaderTest extends TestCase
{
    /**
     * @var VendorServiceLoader
     */
    private $vendorServiceLoader;

    public function testExistsService(): void
    {
        self::assertInstanceOf(DummyVendorService::class, $this->vendorServiceLoader->get('AVendor', 'create'));
        self::assertInstanceOf(DummyVendorService::class, $this->vendorServiceLoader->get('CVendor', 'remove'));
    }

    public function testNotExistsService(): void
    {
        $this->expectException(LogicException::class);

        $this->vendorServiceLoader->get('notexistsvendor', 'notexistsmethod');
    }

    public function testNotExistsMethod(): void
    {
        $this->expectException(LogicException::class);

        $this->vendorServiceLoader->get('AVendor', 'notexistsmethod');
    }

    protected function setUp()
    {
        $builder = new ContainerBuilder();

        $builder->registerExtension(new VendorServiceExtension());

        $builder->register(DummyVendorService::class, DummyVendorService::class);

        $builder->loadFromExtension(
            VendorServiceExtension::ALIAS,
            [
                'AVendor' => [
                    'create' => DummyVendorService::class,
                ],
                'CVendor' => [
                    'remove' => DummyVendorService::class,
                ],
            ]
        );

        $builder->compile();
        $this->vendorServiceLoader = new VendorServiceLoader($builder);
    }
}
