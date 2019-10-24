<?php

namespace VirtualCard\Vendor\Rhino\Service\Client;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Library\Client\RequestOptionsResolver;
use VirtualCard\Service\Client\AbstractClientWrapper;
use VirtualCard\Service\Client\ClientFactory;
use VirtualCard\Vendor\Rhino\Service\RequestBuilder;

class ClientWrapper extends AbstractClientWrapper
{
    /**
     * @var RequestBuilder
     */
    private $requestBuilder;
    
    public function __construct(RequestBuilder $requestBuilder, ClientFactory $clientFactory)
    {
        parent::__construct($clientFactory);
        $this->requestBuilder = $requestBuilder;
    }
    
    /**
     * @param string $method
     * @param string $processId
     * @param array $options
     * @return ResponseInterface
     *
     * @throws RouterMethodNotFoundException
     * @throws GuzzleException
     */
    public function request(string $method, string $processId, array $options = []): ResponseInterface
    {
        $optionsResolver = new RequestOptionsResolver();
        $options = $optionsResolver->resolve($options);
        
        $request = $this->requestBuilder->build($method, $processId);
        
        return $this->send($request, $options);
    }
}