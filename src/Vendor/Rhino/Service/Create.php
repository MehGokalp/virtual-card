<?php

namespace VirtualCard\Vendor\Rhino\Service;

use GuzzleHttp\Exception\GuzzleException;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Schema\Vendor\Create\Result as CreateResult;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Vendor\CreateInterface;
use VirtualCard\Vendor\Rhino\Response\Parser\CreateResponseParser;
use VirtualCard\Vendor\Rhino\Service\Client\ClientWrapper;
use VirtualCard\Vendor\VendorServiceInterface;

class Create implements CreateInterface, VendorServiceInterface
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
     * @param array $virtualCard
     * @return CreateResult
     * @throws GuzzleException
     * @throws RouterMethodNotFoundException
     */
    public function getResult(array $virtualCard): CreateResult
    {
        $response = $this->clientWrapper->request(
            VendorServiceLoader::CREATE,
            http_build_query(
                [
                    'currency' => $virtualCard['currency']->getCode(),
                    'activationDate' => $virtualCard['activationDate']->format('Y-m-d'),
                    'expireDate' => $virtualCard['expireDate']->format('Y-m-d'),
                    'balance' => $virtualCard['balance'],
                ]
            ),
            $virtualCard['processId']
        );

        return CreateResponseParser::parse((string)$response->getBody());
    }
}
