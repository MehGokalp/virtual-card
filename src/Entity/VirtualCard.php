<?php

namespace VirtualCard\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="virtual_card")
 * @ORM\Entity(repositoryClass="VirtualCard\Repository\VirtualCardRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class VirtualCard
{
    use BlameableEntity;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     */
    private $balance;

    /**
     * @ORM\ManyToOne(targetEntity="VirtualCard\Entity\Currency")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $currency;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank()
     */
    private $activationDate;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank()
     */
    private $expireDate;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     *
     * @Assert\Length(max="2048")
     */
    private $notes;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $processId;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(groups={"insertion"})
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"insertion"})
     */
    private $cardNumber;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(groups={"insertion"})
     */
    private $cvc;

    /**
     * @ORM\ManyToOne(targetEntity="VirtualCard\Entity\Bucket")
     * @ORM\JoinColumn(nullable=false)
     */
    private $baseBucket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getActivationDate(): ?DateTimeInterface
    {
        return $this->activationDate;
    }

    public function setActivationDate(DateTimeInterface $activationDate): self
    {
        $this->activationDate = $activationDate;

        return $this;
    }

    public function getExpireDate(): ?DateTimeInterface
    {
        return $this->expireDate;
    }

    public function setExpireDate(DateTimeInterface $expireDate): self
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getProcessId(): ?string
    {
        return $this->processId;
    }

    public function setProcessId(string $processId): self
    {
        $this->processId = $processId;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCvc(): ?string
    {
        return $this->cvc;
    }

    public function setCvc(string $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }

    public function getBaseBucket(): ?Bucket
    {
        return $this->baseBucket;
    }

    public function setBaseBucket(?Bucket $baseBucket): self
    {
        $this->baseBucket = $baseBucket;

        return $this;
    }
}
