<?php

namespace VirtualCard\Repository;

use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use VirtualCard\Entity\Bucket;

/**
 * @method Bucket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bucket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bucket[]    findAll()
 * @method Bucket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BucketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bucket::class);
    }
    
    /**
     * @param DateTimeInterface $activationDate
     * @param DateTimeInterface $expireDate
     *
     * @param int $balance
     * @return array|Bucket[]
     */
    public function findWithActivationExpireWithBalance(DateTimeInterface $activationDate, DateTimeInterface $expireDate, int $balance): array
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->addSelect('v')
            ->addSelect('c')
            ->join('b.vendor', 'v')
            ->join('b.currency', 'c')
            ->andWhere('b.startDate <= :startDate AND b.endDate >= :endDate AND b.expired = 0 AND b.balance > :balance')
            ->setParameter('startDate', $activationDate->format('Y-m-d'))
            ->setParameter('endDate', $expireDate->format('Y-m-d'))
            ->setParameter('balance', $balance)
            ->orderBy('b.balance', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
