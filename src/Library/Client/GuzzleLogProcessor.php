<?php

namespace VirtualCard\Library\Client;

use MongoDate;

class GuzzleLogProcessor
{
    public const DELIMITER = '<DELIMITER>';

    public const LOG_MESSAGE_TEMPLATE = '{target}'.self::DELIMITER
    .'{req_header_x-method}'.self::DELIMITER
    .'{req_header_x-process-id}'.self::DELIMITER
    .'{req_header_x-service}'.self::DELIMITER
    .'{req_headers}'.self::DELIMITER
    .'{res_headers}'.self::DELIMITER
    .'{req_body}'.self::DELIMITER
    .'{res_body}'.self::DELIMITER
    .'{code}';

    /**
     * @param array $record
     *
     * @return array
     */
    public function __invoke(array $record): array
    {
        $data = $this->parseMessage($record['message']);

        return [
            'service' => $data['service'],
            'process_id' => $data['process_id'],
            'method' => $data['method'],
            'date' => new MongoDate(),
            'request_header' => $data['req_headers'],
            'request' => $data['request'],
            'response_header' => $data['res_headers'],
            'response' => $data['response'],
            'code' => $data['code'],
            'level' => $record['level'],
            'level_name' => $record['level_name'],
            'channel' => $record['channel'],
            'extra' => array(),
        ];
    }

    /**
     * @param $message
     *
     * @return array
     */
    public function parseMessage($message): array
    {
        [$target, $method, $process_id, $service, $req_headers, $res_headers, $request, $response, $code] = explode(
            self::DELIMITER,
            $message
        );

        return compact(
            'target',
            'method',
            'process_id',
            'service',
            'req_headers',
            'res_headers',
            'request',
            'response',
            'code'
        );
    }
}
