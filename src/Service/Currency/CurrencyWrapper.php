<?php
namespace VirtualCard\Service\Currency;

use Money\Converter;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Exception\UnknownCurrencyException;
use Money\Exchange\FixedExchange;
use Money\Exchange\ReversedCurrenciesExchange;
use Money\Money;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CurrencyWrapper
{
    private const CACHE_KEY = 'sys.currency_rates';
    private const CACHE_LIFETIME = '3600';
    
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
    
    public function getCurrencyRates(): array
    {
        try {
            return $this->cache->get(self::CACHE_KEY, function (ItemInterface $item) {
                $item->expiresAfter(self::CACHE_LIFETIME);
            
                return $this->fetchCurrencyRates();
            });
        } catch (InvalidArgumentException $e) {
            return [];
        }
    }
    
    public function convert(Money $money, Currency $to): Money
    {
        if ($money->getCurrency()->equals($to)) {
            return $money;
        }
        
        $rates = $this->getCurrencyRates();
        
        if (false === isset($rates[$to->getCode()])) {
            throw new UnknownCurrencyException(sprintf('Currency (%s) is not in supported currencies %s', $to->getCode(), json_encode(array_keys($rates))));
        }
        
        return $this->getCurrencyConverter()->convert($money, $to);
    }
    
    private function fetchCurrencyRates(): array
    {
        // TODO fetch currencies from given url
        return json_decode('{"USD":3.66,"EUR":3.87,"GBP":4.45,"TRY":1}', true);
    }
    
    private function getCurrencyConverter(): Converter
    {
        if ($this->currencyConverter !== null) {
            return $this->currencyConverter;
        }
        
        $rates = $this->getCurrencyRates();
        
        $exchange = new ReversedCurrenciesExchange(new FixedExchange(array_map(static function ($rate) {
            return ['TRY' => $rate];
        }, $rates)));
        
        return $this->currencyConverter = new Converter(new ISOCurrencies(), $exchange);
    }
}