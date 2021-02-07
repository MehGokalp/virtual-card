<?php

namespace VirtualCard\Service\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use VirtualCard\Schema\VirtualCard\Create\Result;

class CreateResultNormalizer implements ContextAwareNormalizerInterface
{
    /**
     * @inheritDoc
     * @var Result $result
     */
    public function normalize($result, $format = null, array $context = [])
    {
        return [
            'processId' => $result->getProcessId(),
            'reference' => $result->getReference(),
            'cardNumber' => $result->getCardNumber(),
            'cvc' => $result->getCvc(),
            'vendor' => $result->getVendor(),
            'currency' => $result->getCurrency(),
            'balance' => $result->getBalance(),
            'activationDate' => $result->getActivationDate()->format('Y-m-d'),
            'expireDate' => $result->getExpireDate()->format('Y-m-d'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof Result;
    }
}
