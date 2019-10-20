<?php

namespace VirtualCard\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="bucket")
 * @ORM\Entity(repositoryClass="VirtualCard\Repository\BucketRepository")
 *
 * @Assert\Callback({"VirtualCard\Service\Bucket\Validator", "validate"})
 */
class Bucket
{
    use TimestampableEntity;
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     */
    private $endDate;

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
     * @ORM\ManyToOne(targetEntity="VirtualCard\Entity\Vendor", inversedBy="buckets")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $vendor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
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

    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    public function setVendor(?Vendor $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }
}
