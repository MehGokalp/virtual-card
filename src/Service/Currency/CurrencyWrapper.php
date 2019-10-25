<?php
namespace VirtualCard\Service\Currency;

use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exchange\FixedExchange;
use Money\Exchange\ReversedCurrenciesExchange;
use Money\Money;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use VirtualCard\Schema\Currency\Rate;
use VirtualCard\Schema\Currency\Result as CurrencyResult;
use VirtualCard\Traits\LoggerTrait;

class CurrencyWrapper
{
    use LoggerTrait;
    
    private const CACHE_KEY = 'sys.currency_rates';
    private const CACHE_LIFETIME = 3600;
    
    /**
     * @var CacheInterface
     */
    private $cache;
    
    /**
     * @var Converter
     */
    private $currencyConverter;
    
    /**
     * CurrencyWrapper constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
    
    public function getCurrencyRates(): CurrencyResult
    {
        try {
            return $this->cache->get(self::CACHE_KEY, function (ItemInterface $item) {
                $item->expiresAfter(self::CACHE_LIFETIME);
            
                return $this->fetchCurrencyRates();
            });
        } catch (InvalidArgumentException $e) {
            $this->logger->alert($e);
            
            return new CurrencyResult();
        }
    }
    
    public function convert(Money $money, Currency $to): Money
    {
        if ($money->getCurrency()->equals($to)) {
            return $money;
        }
        
        return $this->getCurrencyConverter()->convert($money, $to);
    }
    
    private function fetchCurrencyRates(): CurrencyResult
    {
        return (new CurrencyResult())->setRates([
            new Rate('EUR', 'USD', '1.1026'),
            new Rate('EUR', 'TRY', '6.5359')
        ]);
    }
    
    private function getCurrencyConverter(): Converter
    {
        if ($this->currencyConverter !== null) {
            return $this->currencyConverter;
        }
        
        $result = $this->getCurrencyRates();
        
        $groups = [];
        /**
         * @var Rate $rate
         */
        foreach ($result->getRates() AS $rate) {
            $groups[$rate->getFrom()][$rate->getTo()] = $rate->getRate();
        }
        
        $exchange = new ReversedCurrenciesExchange(new FixedExchange($groups));
        
        return $this->currencyConverter = new Converter(new ISOCurrencies(), $exchange);
    }
}