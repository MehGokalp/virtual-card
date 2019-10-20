<?php
namespace VirtualCard\Traits;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerAware
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
    
    /**
     * @required
     *
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }
}
