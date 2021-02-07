<?php

namespace VirtualCard\Traits;

use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidatorAware
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @required
     *
     * @param ValidatorInterface $validator
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }
}
