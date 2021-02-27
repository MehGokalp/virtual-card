<?php

namespace VirtualCard\Schema\Vendor\Create;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Result
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $reference;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Luhn()
     */
    private $cardNumber;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="3", min="3")
     */
    private $cvc;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $currency;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     */
    private $balance;

    /**
     * @var DateTimeInterface
     *
     * @Assert\NotBlank()
     */
    private $activationDate;

    /**
     * @var DateTimeInterface
     *
     * @Assert\NotBlank()
     */
    private $expireDate;

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
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Result
     */
    public function setCurrency(string $currency): Result
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @param int $balance
     * @return Result
     */
    public function setBalance(int $balance): Result
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getActivationDate(): DateTimeInterface
    {
        return $this->activationDate;
    }

    /**
     * @param DateTimeInterface $activationDate
     * @return Result
     */
    public function setActivationDate(DateTimeInterface $activationDate): Result
    {
        $this->activationDate = $activationDate;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getExpireDate(): DateTimeInterface
    {
        return $this->expireDate;
    }

    /**
     * @param DateTimeInterface $expireDate
     * @return Result
     */
    public function setExpireDate(DateTimeInterface $expireDate): Result
    {
        $this->expireDate = $expireDate;

        return $this;
    }
}