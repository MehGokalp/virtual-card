<?php

namespace VirtualCard\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use VirtualCard\Entity\Currency;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Service\Currency\CurrencyFactory;

class CurrencyFixtures extends Fixture
{
    /**
     * @var CurrencyFactory
     */
    private $currencyFactory;
    
    /**
     * CurrencyFixtures constructor.
     * @param CurrencyFactory $currencyFactory
     */
    public function __construct(CurrencyFactory $currencyFactory)
    {
        $this->currencyFactory = $currencyFactory;
    }
    
    /**
     * @param ObjectManager $manager
     * @throws ValidationException
     */
    public function load(ObjectManager $manager)
    {
        foreach ([ Currency::USD, Currency::EUR ] AS $code) {
            $currency = $this->currencyFactory->create($code);
            
            $this->currencyFactory->persist($currency);
            $this->addReference(sprintf('currency_%s', $code), $currency);
        }
        $this->currencyFactory->flush();
    }
}
