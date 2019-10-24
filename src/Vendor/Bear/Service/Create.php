<?php
namespace VirtualCard\Vendor\Bear\Service;

use GuzzleHttp\Exception\GuzzleException;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Exception\Client\RouterMethodNotFoundException;
use VirtualCard\Schema\Vendor\Create\Result as CreateResult;
use VirtualCard\Service\Client\ClientFactory;
use VirtualCard\Service\VendorServiceLoader;
use VirtualCard\Vendor\Bear\Response\Parser\CreateResponseParser;
use VirtualCard\Vendor\CreateInterface;

class Create implements CreateInterface
{
    /**
     * @var RequestBuilder
     */
    private $requestBuilder;
    /**
     * @var ClientFactory
     */
    private $clientFactory;
    
    public function __construct(RequestBuilder $requestBuilder, ClientFactory $clientFactory)
    {
        $this->requestBuilder = $requestBuilder;
        $this->clientFactory = $clientFactory;
    }
    
    /**
     * @param VirtualCard $virtualCard
     * @return CreateResult
     * @throws RouterMethodNotFoundException
     * @throws GuzzleException
     */
    public function getResult(VirtualCard $virtualCard): CreateResult
    {
        $request = $this->requestBuilder->build(VendorServiceLoader::CREATE, $virtualCard->getProcessId());
        $client = $this->clientFactory->get();
        
        $response = $client->send($request);
        
        return CreateResponseParser::parse((string) $response);
    }
}
