<?php

namespace VirtualCard\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="currency")
 * @ORM\Entity(repositoryClass="VirtualCard\Repository\CurrencyRepository")
 */
class Currency
{
    public const DEFAULT = self::USD;

    public const USD = 'USD';
    public const EUR = 'EUR';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     *
     * @Assert\NotBlank()
     */
    private $code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
