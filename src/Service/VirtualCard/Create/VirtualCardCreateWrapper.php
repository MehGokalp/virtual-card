<?php
namespace VirtualCard\Service\VirtualCard\Create;

use Money\Currency;
use Money\Money;
use Throwable;
use VirtualCard\Entity\Currency as CurrencyEntity;
use VirtualCard\Entity\Vendor;
use VirtualCard\Entity\VirtualCard;
use VirtualCard\Exception\VirtualCard\NoMatchingBucketException;
use VirtualCard\Library\Helper\VirtualCardHelper;
use VirtualCard\Repository\BucketRepository;
use VirtualCard\Schema\VirtualCard\Create\Result as CreateResult;
use VirtualCard\Service\Currency\CurrencyWrapper;
use VirtualCard\Traits\LoggerTrait;

class VirtualCardCreateWrapper
{
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
     * VirtualCardWrapper constructor.
     * @param VirtualCardCreateHandler $virtualCardCreateHandler
     * @param BucketRepository $bucketRepository
     * @param CurrencyWrapper $currencyWrapper
     */
    public function __construct(VirtualCardCreateHandler $virtualCardCreateHandler, BucketRepository $bucketRepository, CurrencyWrapper $currencyWrapper)
    {
        $this->bucketRepository = $bucketRepository;
        $this->currencyWrapper = $currencyWrapper;
        $this->virtualCardCreateHandler = $virtualCardCreateHandler;
    }
    
    /**
     * @param VirtualCard $virtualCard
     * @return CreateResult
     * @throws NoMatchingBucketException
     */
    public function add(VirtualCard $virtualCard): CreateResult
    {
        $balance = $this->getBalance($virtualCard);
        
        $buckets = $this->bucketRepository->findWithActivationExpireWithBalance($virtualCard->getActivationDate(), $virtualCard->getExpireDate(), $balance->getAmount());
        
        foreach ($buckets AS $bucket) {
            try {
                /**
                 * @var Vendor $vendor
                 */
                $vendor = $bucket->getVendor();
                $createResult = $this->virtualCardCreateHandler->handle($virtualCard, $vendor);
                
                $entityId = $this->createEntities($createResult, $vendor);
                $createResult->setVirtualCardId($entityId);
                
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
    
    protected function createEntities(CreateResult $createResult, Vendor $vendor): int
    {
    
    }
}
