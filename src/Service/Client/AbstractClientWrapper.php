<?php

namespace VirtualCard\Service\Client;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractClientWrapper implements ClientWrapperInterface
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
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function send(RequestInterface $request, array $options): ResponseInterface
    {
        $client = $this->clientFactory->get($options);
        
        return $client->send($request, $options);
    }
}
