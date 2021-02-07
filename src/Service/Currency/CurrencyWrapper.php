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
use VirtualCard\Exception\Currency\CurrenciesCanNotFetched;
use VirtualCard\Schema\Currency\Rate;
use VirtualCard\Schema\Currency\Result as CurrencyResult;
use VirtualCard\Traits\LoggerTrait;

class CurrencyWrapper
{
    use LoggerTrait;

    private const CACHE_KEY = 'sys.currency_rates';
    private const CACHE_LIFETIME = 3600;

    /**
     * @var Converter
     */
    private $currencyConverter;

    /**
     * @var CurrencyHandler
     */
    private $handler;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * CurrencyWrapper constructor.
     * @param CurrencyHandler $currencyHandler
     * @param CacheInterface $cache
     */
    public function __construct(CurrencyHandler $currencyHandler, CacheInterface $cache)
    {
        $this->handler = $currencyHandler;
        $this->cache = $cache;
    }

    public function convert(Money $money, Currency $to): Money
    {
        if ($money->getCurrency()->equals($to)) {
            return $money;
        }

        return $this->getCurrencyConverter()->convert($money, $to);
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
        foreach ($result->getRates() as $rate) {
            $groups[$rate->getFrom()][$rate->getTo()] = $rate->getRate();
        }

        $exchange = new ReversedCurrenciesExchange(new FixedExchange($groups));

        return $this->currencyConverter = new Converter(new ISOCurrencies(), $exchange);
    }

    private function getCurrencyRates(): CurrencyResult
    {
        try {
            return $this->cache->get(
                self::CACHE_KEY,
                function (ItemInterface $item) {
                    $item->expiresAfter(self::CACHE_LIFETIME);

                    return $this->handler->handle();
                }
            );
        } catch (CurrenciesCanNotFetched $e) {
            $this->logger->alert($e);

            return new CurrencyResult();
        } catch (InvalidArgumentException $e) {
            $this->logger->alert($e);

            return new CurrencyResult();
        }
    }
}