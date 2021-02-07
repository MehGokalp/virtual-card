<?php

namespace VirtualCard\Service\VirtualCard\Create;

use Throwable;
use VirtualCard\Exception\VirtualCard\NoMatchingBucketException;
use VirtualCard\Repository\BucketRepository;
use VirtualCard\Schema\VirtualCard\Create\Result as CreateResult;
use VirtualCard\Service\Bucket\SpendBucketWrapper;
use VirtualCard\Service\VirtualCard\AbstractVirtualCardWrapper;
use VirtualCard\Service\VirtualCard\VirtualCardFactory;
use VirtualCard\Traits\EntityManagerAware;
use VirtualCard\Traits\LoggerTrait;

class VirtualCardCreateWrapper extends AbstractVirtualCardWrapper
{
    use EntityManagerAware;
    use LoggerTrait;

    /** @var VirtualCardCreateHandler */
    private $virtualCardCreateHandler;

    /** @var BucketRepository */
    private $bucketRepository;

    /** @var SpendBucketWrapper */
    private $spendBucketWrapper;

    /** @var VirtualCardFactory */
    private $virtualCardFactory;

    public function __construct(
        VirtualCardCreateHandler $virtualCardCreateHandler,
        BucketRepository $bucketRepository,
        SpendBucketWrapper $spendBucketWrapper,
        VirtualCardFactory $virtualCardFactory
    ) {
        $this->bucketRepository = $bucketRepository;
        $this->virtualCardCreateHandler = $virtualCardCreateHandler;
        $this->spendBucketWrapper = $spendBucketWrapper;
        $this->virtualCardFactory = $virtualCardFactory;
    }

    /**
     * @param array $virtualCard
     * @return CreateResult
     * @throws NoMatchingBucketException
     */
    public function add(array $virtualCard): CreateResult
    {
        $balance = $this->getBalance($virtualCard);

        $buckets = $this->bucketRepository->findWithActivationExpireWithBalance(
            $virtualCard['activationDate'],
            $virtualCard['expireDate'],
            $balance->getAmount(),
            $virtualCard['currency']->getCode()
        );

        foreach ($buckets as $bucket) {
            try {
                if ($this->spendBucketWrapper->canSpend($bucket, $balance) === false) {
                    // Can this bucket spend this balance
                    continue;
                }

                $createResult = $this->virtualCardCreateHandler->handle($virtualCard, $bucket->getVendor());

                $entity = $this->virtualCardFactory->createFromCreateResult(
                    $virtualCard['processId'],
                    $bucket,
                    $createResult
                );
                $this->spendBucketWrapper->spend($bucket, $balance);

                $createResult
                    ->setVirtualCardId($entity->getId())
                    ->setProcessId($entity->getProcessId());

                return $createResult;
            } catch (Throwable $e) {
                // Fallback: If there is an error occurred, try next bucket
                $this->logger->alert($e);

                continue;
            }
        }

        throw new NoMatchingBucketException($virtualCard);
    }
}
