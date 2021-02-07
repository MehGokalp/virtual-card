<?php

namespace VirtualCard\CurrencyProvider\Mocky\Service\Client;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use VirtualCard\CurrencyProvider\ClientWrapperInterface;
use VirtualCard\Library\Client\RequestOptionsResolver;
use VirtualCard\Service\Client\AbstractClientWrapper;
use VirtualCard\Service\Client\ClientFactory;

class ClientWrapper extends AbstractClientWrapper implements ClientWrapperInterface
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
     * @param array $options
     * @return ResponseInterface
     *
     * @throws GuzzleException
     */
    public function request(array $options = []): ResponseInterface
    {
        $optionsResolver = new RequestOptionsResolver();
        $options = $optionsResolver->resolve($options);

        $request = $this->requestBuilder->build();

        return $this->send($request, $options, 'currency_provider_logs');
    }
}