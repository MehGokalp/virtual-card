<?php

namespace VirtualCard\Service\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use MongoClient;
use Monolog\Handler\MongoDBHandler;
use Monolog\Logger;
use VirtualCard\Library\Client\GuzzleLogProcessor;

class ClientFactory
{
    /**
     * @var MongoClient
     */
    protected $mongo;

    /**
     * @var string
     */
    private $mongoDatabaseName;

    /**
     * MultiClient constructor.
     * @param MongoClient $mongo
     * @param string $mongoDatabaseName
     */
    public function __construct(MongoClient $mongo, string $mongoDatabaseName)
    {
        $this->mongo = $mongo;
        $this->mongoDatabaseName = $mongoDatabaseName;
    }

    /**
     * @param array $options
     * @param string $mongoCollectionName
     * @return GuzzleClient
     */
    public function get(array $options = [], string $mongoCollectionName = 'logs'): GuzzleClient
    {
        $handlerStack = HandlerStack::create();
        $logHandler = [new MongoDBHandler($this->mongo, $this->mongoDatabaseName, $mongoCollectionName)];

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
