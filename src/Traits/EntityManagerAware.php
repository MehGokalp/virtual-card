<?php

namespace VirtualCard\Traits;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerAware
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * @required
     *
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
