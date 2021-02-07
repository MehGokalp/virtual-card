<?php

namespace VirtualCard\Schema\VirtualCard\Create;

use DateTimeInterface;

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
    private $cvc;

    /**
     * @var string|null
     */
    private $vendor;

    /**
     * @var int|null
     */
    private $virtualCardId;

    /**
     * @var DateTimeInterface|null
     */
    private $expireDate;

    /**
     * @var string|null
     */
    private $processId;

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
    public function getCvc(): ?string
    {
        return $this->cvc;
    }

    /**
     * @param string|null $cvc
     * @return Result
     */
    public function setCvc(?string $cvc): Result
    {
        $this->cvc = $cvc;

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

    /**
     * @return DateTimeInterface|null
     */
    public function getExpireDate(): ?DateTimeInterface
    {
        return $this->expireDate;
    }

    /**
     * @param DateTimeInterface|null $expireDate
     * @return Result
     */
    public function setExpireDate(?DateTimeInterface $expireDate): Result
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProcessId(): ?string
    {
        return $this->processId;
    }

    /**
     * @param string|null $processId
     * @return Result
     */
    public function setProcessId(?string $processId): Result
    {
        $this->processId = $processId;

        return $this;
    }
}