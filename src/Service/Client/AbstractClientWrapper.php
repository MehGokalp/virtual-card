<?php

namespace VirtualCard\Service\Client;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractClientWrapper
{
    /**
     * @var ClientFactory
     */
    private $clientFactory;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->clientFactory = $clientFactory;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @param string $mongoCollectionName
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function send(
        RequestInterface $request,
        array $options,
        string $mongoCollectionName = 'vendor_logs'
    ): ResponseInterface {
        $client = $this->clientFactory->get($options, $mongoCollectionName);

        return $client->send($request, $options);
    }
}
