<?php

namespace VirtualCard\Schema\VirtualCard\Create;

class Result
{
    /**
     * @var string|null
     */
    private $reference;
    
    /**
     * @var string|null
     */
    private $cardNumber;
    
    /**
     * @var string|null
     */
    private $cvv;
    
    /**
     * @var string|null
     */
    private $vendor;
    
    /**
     * @var int|null
     */
    private $virtualCardId;
    
    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }
    
    /**
     * @param string|null $reference
     * @return Result
     */
    public function setReference(?string $reference): Result
    {
        $this->reference = $reference;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }
    
    /**
     * @param string|null $cardNumber
     * @return Result
     */
    public function setCardNumber(?string $cardNumber): Result
    {
        $this->cardNumber = $cardNumber;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getCvv(): ?string
    {
        return $this->cvv;
    }
    
    /**
     * @param string|null $cvv
     * @return Result
     */
    public function setCvv(?string $cvv): Result
    {
        $this->cvv = $cvv;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getVendor(): ?string
    {
        return $this->vendor;
    }
    
    /**
     * @param string|null $vendor
     * @return Result
     */
    public function setVendor(?string $vendor): Result
    {
        $this->vendor = $vendor;
        
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getVirtualCardId(): ?int
    {
        return $this->virtualCardId;
    }
    
    /**
     * @param int|null $virtualCardId
     * @return Result
     */
    public function setVirtualCardId(?int $virtualCardId): Result
    {
        $this->virtualCardId = $virtualCardId;
        
        return $this;
    }
}