<?php

namespace VirtualCard\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Service\Vendor\VendorFactory;

class VendorFixtures extends Fixture
{
    /** @var VendorFactory */
    private $vendorFactory;

    public function __construct(VendorFactory $vendorFactory)
    {
        $this->vendorFactory = $vendorFactory;
    }

    public function load(ObjectManager $manager)
    {
        $vendors = [
            Vendor::BEAR => [
                'limit' => 200000,
                'delta' => 29,
            ],
            Vendor::LION => [
                'limit' => 50000,
                'delta' => 13,
            ],
            Vendor::RHINO => [
                'limit' => 100000,
                'delta' => 19,
            ],
        ];

        foreach ($vendors as $slug => $data) {
            // * 100 needed because we're keeping the money instances in cent/kuruş type on database
            $vendor = $this->vendorFactory->create($slug, $data['delta'], $data['limit'] * 100);
            $this->addReference(sprintf('vendor_%s', $slug), $vendor);

            $this->vendorFactory->persist($vendor);
        }
        $this->vendorFactory->flush();
    }
}
