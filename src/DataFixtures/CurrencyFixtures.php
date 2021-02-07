<?php

namespace VirtualCard\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use VirtualCard\Entity\Currency;
use VirtualCard\Service\Currency\CurrencyFactory;

class CurrencyFixtures extends Fixture
{
    /** @var CurrencyFactory */
    private $currencyFactory;

    public function __construct(CurrencyFactory $currencyFactory)
    {
        $this->currencyFactory = $currencyFactory;
    }

    public function load(ObjectManager $manager)
    {
        foreach ([Currency::USD, Currency::EUR] as $code) {
            $currency = $this->currencyFactory->create($code);

            $this->currencyFactory->persist($currency);
            $this->addReference(sprintf('currency_%s', $code), $currency);
        }
        $this->currencyFactory->flush();
    }
}
