<?php
namespace VirtualCard\Service\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Handler\MongoDBHandler;
use Monolog\Logger;
use VirtualCard\Library\Client\GuzzleLogProcessor;

class ClientFactory
{
    
    /**
     * @var \MongoClient $mongo
     */
    protected $mongo;
    
    /**
     * @var string
     */
    private $mongoDatabaseName;
    
    /**
     * @var string
     */
    private $mongoCollectionName;
    
    /**
     * MultiClient constructor.
     * @param $mongo
     * @param string $mongoDatabaseName
     * @param string $mongoCollectionName
     */
    public function __construct($mongo, string $mongoDatabaseName, string $mongoCollectionName)
    {
        $this->mongo = $mongo;
        $this->mongoDatabaseName = $mongoDatabaseName;
        $this->mongoCollectionName = $mongoCollectionName;
    }
    
    /**
     * @param array $options
     * @return GuzzleClient
     */
    public function get(array $options = []): GuzzleClient
    {
        $handlerStack = HandlerStack::create();
        $logHandler = [new MongoDBHandler($this->mongo, $this->mongoDatabaseName, $this->mongoCollectionName)];
        
        $logger = new Logger(
            'client_logger',
            $logHandler,
            [new GuzzleLogProcessor()]
        );
        
        $handlerStack->push(
            Middleware::log(
                $logger,
                new MessageFormatter(
                    GuzzleLogProcessor::LOG_MESSAGE_TEMPLATE
                )
            )
        );
        
        return new GuzzleClient(array_merge(['handler' => $handlerStack], $options));
    }
}
