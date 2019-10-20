<?php

namespace VirtualCard\Repository;

use VirtualCard\Entity\VirtualCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VirtualCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method VirtualCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method VirtualCard[]    findAll()
 * @method VirtualCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VirtualCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VirtualCard::class);
    }
}
