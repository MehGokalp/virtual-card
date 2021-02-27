<?php

namespace VirtualCard\Service\VirtualCard;

use VirtualCard\Entity\Bucket;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Exception\ValidationException;
use VirtualCard\Repository\CurrencyRepository;
use VirtualCard\Schema\VirtualCard\Create\Result as CreateResult;
use VirtualCard\Service\Factory\AbstractFactory;
use VirtualCard\Traits\ValidatorAware;

class VirtualCardFactory extends AbstractFactory
{
    use ValidatorAware;

    /** @var CurrencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function createFromCreateResult(string $processId, Bucket $bucket, CreateResult $createResult): VirtualCard
    {
        $baseBucket = $bucket->getBase();

        $virtualCard = new VirtualCard();

        $virtualCard
            ->setCurrency($this->currencyRepository->findCurrencyByCode($createResult->getCurrency()))
            ->setProcessId($processId)
            ->setBaseBucket($baseBucket ?? $bucket)
            ->setCardNumber($createResult->getCardNumber())
            ->setCvc($createResult->getCvc())
            ->setReference($createResult->getReference())
            ->setActivationDate($createResult->getActivationDate())
            ->setExpireDate($createResult->getExpireDate())
            ->setBalance($createResult->getBalance());

        $errors = $this->validator->validate($virtualCard);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        $this->persist($virtualCard);
        $this->flush();

        return $virtualCard;
    }
}