<?php

namespace VirtualCard\Exception\Currency;

use Exception;
use Throwable;

class CurrenciesCanNotFetched extends Exception
{
    public function __construct(
        $message = 'Currencies can not fetched from any provider.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}