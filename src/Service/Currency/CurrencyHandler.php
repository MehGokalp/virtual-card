<?php

namespace VirtualCard\Service\Currency;

use GuzzleHttp\Exception\GuzzleException;
use Throwable;
use VirtualCard\CurrencyProvider\Mocky\Service\Rate;
use VirtualCard\Exception\Currency\CurrenciesCanNotFetched;
use VirtualCard\Schema\Currency\Result as CurrencyResult;
use VirtualCard\Traits\LoggerTrait;

class CurrencyHandler
{
    use LoggerTrait;

    /**
     * @var iterable|Rate[]
     */
    private $services;

    /**
     * CurrencyHandler constructor.
     * @param iterable|Rate[] $services
     */
    public function __construct(iterable $services)
    {
        $this->services = $services;
    }

    /**
     * @return CurrencyResult
     * @throws CurrenciesCanNotFetched
     */
    public function handle(): CurrencyResult
    {
        foreach ($this->services as $service) {
            try {
                return $service->getResult();
            } catch (Throwable | GuzzleException $e) {
                $this->logger->alert($e);
            }
        }

        throw new CurrenciesCanNotFetched();
    }
}