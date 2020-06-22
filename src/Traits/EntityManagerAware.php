<?php
namespace VirtualCard\Traits;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerAware
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
    
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
