<?php

namespace VirtualCard\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vendor")
 * @ORM\Entity(repositoryClass="VirtualCard\Repository\VendorRepository")
 */
class Vendor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $bucketLimit;

    /**
     * @ORM\Column(type="integer")
     */
    private $bucketDateDelta;

    /**
     * @ORM\OneToMany(targetEntity="VirtualCard\Entity\VirtualCard", mappedBy="vendor", orphanRemoval=true)
     */
    private $virtualCards;

    /**
     * @ORM\OneToMany(targetEntity="VirtualCard\Entity\Bucket", mappedBy="vendor", orphanRemoval=true)
     */
    private $buckets;

    public function __construct()
    {
        $this->virtualCards = new ArrayCollection();
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
     * @return Collection|VirtualCard[]
     */
    public function getVirtualCards(): Collection
    {
        return $this->virtualCards;
    }

    public function addVirtualCard(VirtualCard $virtualCard): self
    {
        if (!$this->virtualCards->contains($virtualCard)) {
            $this->virtualCards[] = $virtualCard;
            $virtualCard->setVendor($this);
        }

        return $this;
    }

    public function removeVirtualCard(VirtualCard $virtualCard): self
    {
        if ($this->virtualCards->contains($virtualCard)) {
            $this->virtualCards->removeElement($virtualCard);
            // set the owning side to null (unless already changed)
            if ($virtualCard->getVendor() === $this) {
                $virtualCard->setVendor(null);
            }
        }

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
