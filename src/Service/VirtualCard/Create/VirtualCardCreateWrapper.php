<?php

namespace VirtualCard\Service\VirtualCard\Create;

use Money\Currency;
use Money\Money;
use Throwable;
use VirtualCard\Entity\Bucket;
use VirtualCard\Entity\Currency as CurrencyEntity;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Exception\VirtualCard\NoMatchingBucketException;
use VirtualCard\Library\Helper\VirtualCardHelper;
use VirtualCard\Repository\BucketRepository;
use VirtualCard\Schema\VirtualCard\Create\Result as CreateResult;
use VirtualCard\Service\Bucket\SpendBucketWrapper;
use VirtualCard\Service\Currency\CurrencyWrapper;
use VirtualCard\Traits\EntityManagerAware;
use VirtualCard\Traits\LoggerTrait;

class VirtualCardCreateWrapper
{
    use EntityManagerAware;
    use LoggerTrait;

    /**
     * @var VirtualCardCreateHandler
     */
    private $virtualCardCreateHandler;

    /**
     * @var BucketRepository
     */
    private $bucketRepository;

    /**
     * @var CurrencyWrapper
     */
    private $currencyWrapper;

    /**
     * @var SpendBucketWrapper
     */
    private $spendBucketWrapper;

    /**
     * VirtualCardWrapper constructor.
     * @param VirtualCardCreateHandler $virtualCardCreateHandler
     * @param BucketRepository $bucketRepository
     * @param CurrencyWrapper $currencyWrapper
     * @param SpendBucketWrapper $spendBucketWrapper
     */
    public function __construct(
        VirtualCardCreateHandler $virtualCardCreateHandler,
        BucketRepository $bucketRepository,
        CurrencyWrapper $currencyWrapper,
        SpendBucketWrapper $spendBucketWrapper
    ) {
        $this->bucketRepository = $bucketRepository;
        $this->currencyWrapper = $currencyWrapper;
        $this->virtualCardCreateHandler = $virtualCardCreateHandler;
        $this->spendBucketWrapper = $spendBucketWrapper;
    }

    /**
     * @param VirtualCard $virtualCard
     * @return CreateResult
     * @throws NoMatchingBucketException
     */
    public function add(VirtualCard $virtualCard): CreateResult
    {
        $balance = $this->getBalance($virtualCard);

        $buckets = $this->bucketRepository->findWithActivationExpireWithBalance(
            $virtualCard->getActivationDate(),
            $virtualCard->getExpireDate(),
            $balance->getAmount()
        );

        foreach ($buckets as $bucket) {
            try {
                if ($this->spendBucketWrapper->canSpend($bucket, $balance) === false) {
                    // Can this bucket spend this balance
                    continue;
                }

                $createResult = $this->virtualCardCreateHandler->handle($virtualCard, $bucket->getVendor());

                $this->buildVirtualCard($virtualCard, $bucket, $createResult);
                $this->spendBucketWrapper->spend($bucket, $balance);

                $this->save($virtualCard);
                $createResult
                    ->setVirtualCardId($virtualCard->getId())
                    ->setProcessId($virtualCard->getProcessId())
                ;

                return $createResult;
            } catch (Throwable $e) {
                // Fallback: If there is an error occurred, try next bucket
                $this->logger->alert($e);

                continue;
            }
        }

        throw new NoMatchingBucketException($virtualCard);
    }

    protected function getBalance(VirtualCard $virtualCard): Money
    {
        $balance = VirtualCardHelper::getBalanceAsMoney($virtualCard);
        if ($virtualCard->getCurrency()->getCode() !== CurrencyEntity::DEFAULT) {
            $balance = $this->currencyWrapper->convert($balance, new Currency(CurrencyEntity::DEFAULT));
        }

        return $balance;
    }

    protected function buildVirtualCard(VirtualCard $virtualCard, Bucket $bucket, CreateResult $createResult): void
    {
        $baseBucket = $bucket->getBase();

        $virtualCard
            ->setBaseBucket($baseBucket ?? $bucket)
            ->setCardNumber($createResult->getCardNumber())
            ->setCvc($createResult->getCvc())
            ->setReference($createResult->getReference())
            ->setActivationDate($createResult->getActivationDate())
            ->setExpireDate($createResult->getExpireDate())
            ->setBalance($createResult->getBalance())
        ;
    }

    protected function save(VirtualCard $virtualCard): void
    {
        $this->entityManager->persist($virtualCard);
        $this->entityManager->flush();
    }
}
