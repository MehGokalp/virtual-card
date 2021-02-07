<?php

namespace VirtualCard\Service\Normalizer;

use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use VirtualCard\Entity\VirtualCard;

class VirtualCardNormalizer implements ContextAwareNormalizerInterface
{
    /**
     * @inheritDoc
     * @var VirtualCard $virtualCard
     */
    public function normalize($virtualCard, $format = null, array $context = [])
    {
        return [
            'balance' => $virtualCard->getBalance(),
            'currency' => $virtualCard->getCurrency()->getCode(),
            'activationDate' => $virtualCard->getActivationDate()->format('Y-m-d'),
            'expireDate' => $virtualCard->getExpireDate()->format('Y-m-d'),
            'cardNumber' => $virtualCard->getCardNumber(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        return $data instanceof VirtualCard;
    }
}
