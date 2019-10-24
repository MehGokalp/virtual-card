<?php
namespace VirtualCard\Vendor\Rhino\Service;

use GuzzleHttp\Exception\GuzzleException;
use VirtualCard\Entity\VirtualCard;
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
     * @param VirtualCard $virtualCard
     * @return CreateResult
     * @throws RouterMethodNotFoundException
     * @throws GuzzleException
     */
    public function getResult(VirtualCard $virtualCard): CreateResult
    {
        $response = $this->clientWrapper->request(VendorServiceLoader::CREATE, $virtualCard->getProcessId());
        
        return CreateResponseParser::parse((string) $response->getBody());
    }
}
