<?php

namespace VirtualCard\Library\Client;

use GuzzleHttp\RequestOptions;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestOptionsResolver extends OptionsResolver
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        $defaults = [
            RequestOptions::VERIFY => true,
            RequestOptions::CONNECT_TIMEOUT => 5,
            RequestOptions::TIMEOUT => 45,
            'curl' => [
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            ],
            'headers' => [],
        ];

        $this->setDefaults($defaults);

        $this->setRequired(array_keys($defaults));
    }

}
