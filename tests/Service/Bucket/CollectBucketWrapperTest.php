<?php

namespace VirtualCard\Tests\Service\Bucket;

use Money\Money;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Entity\Bucket;
use VirtualCard\Entity\Currency;
use VirtualCard\Service\Bucket\CollectBucketWrapper;

class CollectBucketWrapperTest extends TestCase
{
    /**
     * @var CollectBucketWrapper
     */
    private $mock;

    public function setUp()
    {
        $mockBuilder = $this->getMockBuilder(CollectBucketWrapper::class);
        $mockBuilder
            ->disableOriginalConstructor()
            ->setMethods(['persist', 'save']);

        $mock = $mockBuilder->getMock();
        $mock
            ->method('persist')
            ->with(self::isInstanceOf(Bucket::class))
            ->willReturnSelf();

        $mock
            ->method('save')
            ->willReturnSelf();

        $this->mock = $mock;
    }

    protected function createBucket(int $balance): Bucket
    {
        $bucket = new Bucket();
        $bucket->setBalance($balance);
        $bucket->setCurrency((new Currency())->setCode(Currency::EUR));

        return $bucket;
    }

    protected function createMoney(int $amount, string $currency): Money
    {
        return new Money($amount, new \Money\Currency($currency));
    }

    public function testSuccessClone(): void
    {
        $balance = 1000000;
        $base = $this->createBucket($balance);

        $cloned = $this->mock->collect($base, $this->createMoney($balance, Currency::EUR));

        // Do not change the $base's balance
        self::assertSame($base->getBalance(), $balance);
        self::assertSame($cloned->getBalance(), $balance * 2);

        // All properties must be same
        self::assertSame($cloned->getCurrency(), $base->getCurrency());
        self::assertSame($cloned->getVendor(), $base->getVendor());
        self::assertSame($cloned->getStartDate(), $base->getStartDate());
        self::assertSame($cloned->getEndDate(), $base->getEndDate());
        self::assertFalse($cloned->isExpired());
        self::assertTrue($base->isExpired());

        // We did not declare a parent or base bucket to our $base bucket
        // So parent and base class will same
        self::assertSame($cloned->getParent(), $base);
        self::assertSame($cloned->getBase(), $base);
    }

    public function testDifferentCurrency(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $bucket = $this->createBucket(1111);
        $this->mock->collect($bucket, $this->createMoney(5, Currency::USD));
    }
}
