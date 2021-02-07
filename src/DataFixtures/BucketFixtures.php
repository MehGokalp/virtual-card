<?php

namespace VirtualCard\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VirtualCard\Entity\Currency;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Service\Bucket\BucketFactory;

class BucketFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var BucketFactory
     */
    private $bucketFactory;

    public function __construct(BucketFactory $bucketFactory)
    {
        $this->bucketFactory = $bucketFactory;
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws ValidationException
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $buckets = [
            Vendor::BEAR => [
                ['2020-01-01', Currency::USD],
                ['2020-02-01', Currency::USD],
                ['2020-03-03', Currency::USD],
            ],
            Vendor::LION => [
                ['2020-01-01', Currency::USD],
                ['2020-01-15', Currency::USD],
                ['2020-01-29', Currency::USD],
            ],
            Vendor::RHINO => [
                ['2020-01-01', Currency::USD],
                ['2020-01-21', Currency::USD],
            ],
        ];

        foreach ($buckets as $vendor => $bucketList) {
            /**
             * @var Vendor $vendor
             */
            $vendor = $this->getReference(sprintf('vendor_%s', $vendor));

            foreach ($bucketList as $bucket) {
                /**
                 * @var Currency $currency
                 */
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
