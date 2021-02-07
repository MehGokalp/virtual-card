<?php

namespace VirtualCard\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use VirtualCard\Entity\Currency;
use VirtualCard\Entity\Vendor;
use VirtualCard\Service\Bucket\BucketFactory;

class BucketFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var BucketFactory */
    private $bucketFactory;

    public function __construct(BucketFactory $bucketFactory)
    {
        $this->bucketFactory = $bucketFactory;
    }

    public function load(ObjectManager $manager)
    {
        $buckets = [
            Vendor::BEAR => [
                [(new DateTime())->modify('+1 month')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+2 month')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+3 month')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+3 month')->format('Y-m-d'), Currency::EUR],
            ],
            Vendor::LION => [
                [(new DateTime())->modify('+2 month')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+3 month')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+4 month')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+2 month')->format('Y-m-d'), Currency::EUR],
                [(new DateTime())->modify('+3 month')->format('Y-m-d'), Currency::EUR],
                [(new DateTime())->modify('+4 month')->format('Y-m-d'), Currency::EUR],
            ],
            Vendor::RHINO => [
                [(new DateTime())->modify('+15 days')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+45 days')->format('Y-m-d'), Currency::USD],
                [(new DateTime())->modify('+45 days')->format('Y-m-d'), Currency::EUR],
            ],
        ];

        foreach ($buckets as $vendor => $bucketList) {
            /** @var Vendor $vendor */
            $vendor = $this->getReference(sprintf('vendor_%s', $vendor));

            foreach ($bucketList as $bucket) {
                /** @var Currency $currency */
                $currency = $this->getReference(sprintf('currency_%s', $bucket[1]));
                $startTime = new DateTime($bucket[0]);
                $endDate = (clone $startTime)->modify(sprintf('+%d days', $vendor->getBucketDateDelta()));
                $bucket = $this->bucketFactory->create($startTime, $endDate, $vendor, $currency);

                $this->bucketFactory->persist($bucket);
            }
        }

        $this->bucketFactory->flush();
    }

    public function getDependencies()
    {
        return [
            CurrencyFixtures::class,
            VendorFixtures::class,
        ];
    }
}
