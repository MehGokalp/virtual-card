<?php

namespace VirtualCard\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="vendor")
 * @ORM\Entity(repositoryClass="VirtualCard\Repository\VendorRepository")
 */
class Vendor
{
    public const BEAR = 'bear';
    public const LION = 'lion';
    public const RHINO = 'rhino';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     *
     * @Assert\NotBlank()
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     */
    private $bucketLimit;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     */
    private $bucketDateDelta;

    /**
     * @ORM\OneToMany(targetEntity="VirtualCard\Entity\Bucket", mappedBy="vendor", orphanRemoval=true)
     */
    private $buckets;

    public function __construct()
    {
        $this->buckets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getBucketLimit(): ?int
    {
        return $this->bucketLimit;
    }

    public function setBucketLimit(int $bucketLimit): self
    {
        $this->bucketLimit = $bucketLimit;

        return $this;
    }

    public function getBucketDateDelta(): ?int
    {
        return $this->bucketDateDelta;
    }

    public function setBucketDateDelta(int $bucketDateDelta): self
    {
        $this->bucketDateDelta = $bucketDateDelta;

        return $this;
    }

    /**
     * @return Collection|Bucket[]
     */
    public function getBuckets(): Collection
    {
        return $this->buckets;
    }

    public function addBucket(Bucket $bucket): self
    {
        if (!$this->buckets->contains($bucket)) {
            $this->buckets[] = $bucket;
            $bucket->setVendor($this);
        }

        return $this;
    }

    public function removeBucket(Bucket $bucket): self
    {
        if ($this->buckets->contains($bucket)) {
            $this->buckets->removeElement($bucket);
            // set the owning side to null (unless already changed)
            if ($bucket->getVendor() === $this) {
                $bucket->setVendor(null);
            }
        }

        return $this;
    }
}
