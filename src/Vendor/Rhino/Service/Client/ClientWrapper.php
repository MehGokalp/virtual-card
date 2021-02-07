<?php

namespace VirtualCard\Vendor\Rhino\Service\Client;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Library\Client\RequestOptionsResolver;
use VirtualCard\Service\Client\AbstractClientWrapper;
use VirtualCard\Service\Client\ClientFactory;
use VirtualCard\Vendor\ClientWrapperInterface;

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
     * @param string $method
     * @param array|null $body
     * @param string $processId
     * @param array $options
     * @return ResponseInterface
     *
     * @throws GuzzleException
     * @throws RouterMethodNotFoundException
     */
    public function request(string $method, ?string $body, string $processId, array $options = []): ResponseInterface
    {
        $optionsResolver = new RequestOptionsResolver();
        $options = $optionsResolver->resolve($options);

        $request = $this->requestBuilder->build($method, $processId, $body);

        return $this->send($request, $options);
    }
}