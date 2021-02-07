<?php

namespace VirtualCard\Service\Currency;

use VirtualCard\Entity\Currency;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Service\Factory\AbstractFactory;
use VirtualCard\Traits\ValidatorAware;

class CurrencyFactory extends AbstractFactory
{
    use ValidatorAware;

    /**
     * @param string $code
     * @return Currency
     *
     * @throws ValidationException
     */
    public function create(string $code): Currency
    {
        $currency = new Currency();

        $currency->setCode($code);

        $errors = $this->validator->validate($currency);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        return $currency;
    }
}
