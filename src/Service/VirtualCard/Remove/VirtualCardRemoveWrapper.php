<?php

namespace VirtualCard\Service\VirtualCard\Remove;

use DateTime;
use Money\Currency;
use Money\Money;
use Throwable;
use VirtualCard\Entity\Currency as CurrencyEntity;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Exception\VirtualCard\ExpiredVirtualCardException;
use VirtualCard\Exception\VirtualCard\VirtualCardNotFoundException;
use VirtualCard\Repository\BucketRepository;
use VirtualCard\Repository\VirtualCardRepository;
use VirtualCard\Schema\VirtualCard\Remove\Result as RemoveResult;
use VirtualCard\Service\Bucket\CollectBucketWrapper;
use VirtualCard\Service\Currency\CurrencyWrapper;
use VirtualCard\Service\Factory\MoneyFactory;
use VirtualCard\Traits\EntityManagerAware;
use VirtualCard\Traits\LoggerTrait;

class VirtualCardRemoveWrapper
{
    use EntityManagerAware;
    use LoggerTrait;

    /**
     * @var BucketRepository
     */
    private $bucketRepository;

    /**
     * @var CurrencyWrapper
     */
    private $currencyWrapper;

    /**
     * @var VirtualCardRemoveHandler
     */
    private $virtualCardRemoveHandler;

    /**
     * @var VirtualCardRepository
     */
    private $virtualCardRepository;

    /**
     * @var CollectBucketWrapper
     */
    private $collectBucketWrapper;

    /**
     * VirtualCardWrapper constructor.
     * @param VirtualCardRemoveHandler $virtualCardRemoveHandler
     * @param BucketRepository $bucketRepository
     * @param VirtualCardRepository $virtualCardRepository
     * @param CurrencyWrapper $currencyWrapper
     * @param CollectBucketWrapper $collectBucketWrapper
     */
    public function __construct(
        VirtualCardRemoveHandler $virtualCardRemoveHandler,
        BucketRepository $bucketRepository,
        VirtualCardRepository $virtualCardRepository,
        CurrencyWrapper $currencyWrapper,
        CollectBucketWrapper $collectBucketWrapper
    ) {
        $this->bucketRepository = $bucketRepository;
        $this->currencyWrapper = $currencyWrapper;
        $this->virtualCardRemoveHandler = $virtualCardRemoveHandler;
        $this->virtualCardRepository = $virtualCardRepository;
        $this->collectBucketWrapper = $collectBucketWrapper;
    }

    /**
     * @param string $reference
     * @return VirtualCard
     * @throws ExpiredVirtualCardException
     * @throws VirtualCardNotFoundException
     */
    public function check(string $reference): VirtualCard
    {
        $virtualCard = $this->virtualCardRepository->findVirtualCardByRef($reference);

        if ($virtualCard === null) {
            throw new VirtualCardNotFoundException(
                sprintf('Virtual card not found with given reference: %s', $reference)
            );
        }

        if ($virtualCard->getExpireDate() < (new DateTime())->setTime(0, 0, 0)) {
            throw new ExpiredVirtualCardException($virtualCard);
        }

        return $virtualCard;
    }

    /**
     * @param VirtualCard $virtualCard
     * @return RemoveResult
     * @throws Throwable
     */
    public function remove(VirtualCard $virtualCard): RemoveResult
    {
        try {
            $latestBucketState = $this->bucketRepository->getLatestState($virtualCard->getBaseBucket());

            $removeResult = $this->virtualCardRemoveHandler->handle($virtualCard, $latestBucketState->getVendor());

            $balance = $this->getBalance($virtualCard);
            $this->virtualCardRepository->remove($virtualCard);
            $this->collectBucketWrapper->collect($latestBucketState, $balance);

            $this->save();

            return $removeResult;
        } catch (Throwable $e) {
            $this->logger->alert($e);

            throw $e;
        }
    }

    protected function getBalance(VirtualCard $virtualCard): Money
    {
        $balance = MoneyFactory::create($virtualCard->getBalance(), $virtualCard->getCurrency()->getCode());
        if ($virtualCard->getCurrency()->getCode() !== CurrencyEntity::DEFAULT) {
            $balance = $this->currencyWrapper->convert($balance, new Currency(CurrencyEntity::DEFAULT));
        }

        return $balance;
    }

    protected function save(): void
    {
        $this->entityManager->flush();
    }
}
