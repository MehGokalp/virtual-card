<?php

namespace VirtualCard\Tests\Service\Bucket;

use DateTime;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use VirtualCard\Entity\Bucket;
use VirtualCard\Entity\Currency;
use VirtualCard\Entity\Vendor;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Service\Bucket\BucketFactory;
use VirtualCard\Service\Currency\CurrencyFactory;
use VirtualCard\Service\Vendor\VendorFactory;

class BucketFactoryTest extends WebTestCase
{
    /**
     * @var BucketFactory
     */
    private static $bucketFactory;

    /**
     * @var VendorFactory
     */
    private static $vendorFactory;

    /**
     * @var CurrencyFactory
     */
    private static $currencyFactory;

    public static function setUpBeforeClass()
    {
        self::bootKernel();
        $container = self::$container;

        self::$bucketFactory = $container->get(BucketFactory::class);
        self::$vendorFactory = $container->get(VendorFactory::class);
        self::$currencyFactory = $container->get(CurrencyFactory::class);
    }

    /**
     * @dataProvider provideValidData
     *
     * @param int $bucketDateDelta
     * @param int $bucketLimit
     * @param string $currencyCode
     * @param string $startDate
     * @param string $endDate
     * @throws ValidationException
     */
    public function testValidCreate(
        int $bucketDateDelta,
        int $bucketLimit,
        string $currencyCode,
        string $startDate,
        string $endDate
    ): void {
        $vendor = $this->getVendor($bucketDateDelta, $bucketLimit);
        $currency = $this->getCurrency($currencyCode);

        $bucket = self::$bucketFactory->create(new DateTime($startDate), new DateTime($endDate), $vendor, $currency);

        $this->assertInstanceOf(Bucket::class, $bucket);
    }

    /**
     * @param int $bucketDateDelta
     * @param int $bucketLimit
     * @return Vendor
     */
    private function getVendor(int $bucketDateDelta, int $bucketLimit): Vendor
    {
        try {
            return self::$vendorFactory->create('test', $bucketDateDelta, $bucketLimit);
        } catch (ValidationException $e) {
            throw new LogicException('Can not get vendor', 0, $e);
        }
    }

    /**
     * @param string $code
     * @return Currency
     */
    private function getCurrency(string $code): Currency
    {
        try {
            return self::$currencyFactory->create($code);
        } catch (ValidationException $e) {
            throw new LogicException('Can not get vendor', 0, $e);
        }
    }

    public function provideValidData(): array
    {
        return [
            [10, 200, Currency::USD, '2020-01-01', '2020-01-11'],
            [10, 200, Currency::EUR, '2020-01-01 23:59:59', '2020-01-11'],
            [10, 200, Currency::USD, '2020-01-01 23:59:59', '2020-01-11 23:59:59'],
        ];
    }

    /**
     * @dataProvider provideInvalidData
     *
     * @param int $bucketDateDelta
     * @param int $bucketLimit
     * @param string $currencyCode
     * @param string $startDate
     * @param string $endDate
     * @throws ValidationException
     */
    public function testInvalidCreate(
        int $bucketDateDelta,
        int $bucketLimit,
        string $currencyCode,
        string $startDate,
        string $endDate
    ): void {
        $vendor = $this->getVendor($bucketDateDelta, $bucketLimit);
        $currency = $this->getCurrency($currencyCode);

        $this->expectException(ValidationException::class);

        self::$bucketFactory->create(new DateTime($startDate), new DateTime($endDate), $vendor, $currency);
    }

    public function provideInvalidData(): array
    {
        return [
            [10, 200, Currency::USD, '2020-01-01', '2020-01-12'],
            // Delta is not true
            [10, 200, Currency::USD, '2020-01-05', '2020-01-01'],
            // End date is before start date
            [10, 200, Currency::USD, '2020-01-11', '2020-01-01'],
            // End date is before start date and date range is same but negative
            [10, 200, Currency::USD, '2020-01-03 23:59:59', '2020-01-11 23:59:59'],
        ];
    }
}
