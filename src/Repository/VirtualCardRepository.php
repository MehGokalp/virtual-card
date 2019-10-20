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

    // /**
    //  * @return VirtualCard[] Returns an array of VirtualCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VirtualCard
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
