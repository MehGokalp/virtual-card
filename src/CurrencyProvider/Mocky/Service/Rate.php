<?php

namespace VirtualCard\CurrencyProvider\Mocky\Service;

use GuzzleHttp\Exception\GuzzleException;
use VirtualCard\CurrencyProvider\CurrencyServiceInterface;
use VirtualCard\CurrencyProvider\Mocky\Parser\CurrencyResponseParser;
use VirtualCard\CurrencyProvider\Mocky\Service\Client\ClientWrapper;
use VirtualCard\CurrencyProvider\RateInterface;
use VirtualCard\Schema\Currency\Result as CurrencyResult;

class Rate implements RateInterface, CurrencyServiceInterface
{
    /**
     * @var ClientWrapper
     */
    private $clientWrapper;

    public function __construct(ClientWrapper $clientWrapper)
    {
        $this->clientWrapper = $clientWrapper;
    }

    /**
     * @return CurrencyResult
     * @throws GuzzleException
     */
    public function getResult(): CurrencyResult
    {
        $response = $this->clientWrapper->request();

        return CurrencyResponseParser::parse((string)$response->getBody());
    }
}