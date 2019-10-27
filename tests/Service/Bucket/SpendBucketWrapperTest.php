<?php

namespace VirtualCard\Tests\Service\Bucket;

use Money\Money;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use VirtualCard\Entity\Bucket;
use VirtualCard\Entity\Currency;
use VirtualCard\Service\Bucket\SpendBucketWrapper;

class SpendBucketWrapperTest extends TestCase
{
    /**
     * @var SpendBucketWrapper
     */
    private $mock;
    
    public function setUp()
    {
        $mockBuilder = $this->getMockBuilder(SpendBucketWrapper::class);
        $mockBuilder
            ->disableOriginalConstructor()
            ->setMethods([ 'persist', 'save' ])
        ;
        
        $mock = $mockBuilder->getMock();
        $mock
            ->method('persist')
            ->with($this->isInstanceOf(Bucket::class))
            ->willReturnSelf()
        ;
        
        $mock
            ->method('save')
            ->willReturnSelf()
        ;
        
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
        
        $cloned = $this->mock->spend($base, $this->createMoney($balance, Currency::EUR));
        
        // Do not change the $base's balance
        $this->assertSame($base->getBalance(), $balance);
        $this->assertSame($cloned->getBalance(), 0);
        
        // All properties must be same
        $this->assertSame($cloned->getCurrency(), $base->getCurrency());
        $this->assertSame($cloned->getVendor(), $base->getVendor());
        $this->assertSame($cloned->getStartDate(), $base->getStartDate());
        $this->assertSame($cloned->getEndDate(), $base->getEndDate());
        $this->assertFalse($cloned->isExpired());
        $this->assertTrue($base->isExpired());
        
        // We did not declare a parent or base bucket to our $base bucket
        // So parent and base class will same
        $this->assertSame($cloned->getParent(), $base);
        $this->assertSame($cloned->getBase(), $base);
    }
    
    public function testDifferentCurrency(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $bucket = $this->createBucket(1111);
        $this->mock->spend($bucket, $this->createMoney(5, Currency::USD));
    }
}
