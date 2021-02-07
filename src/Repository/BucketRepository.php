<?php

namespace VirtualCard\Repository;

use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
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
     * @param string $currencyCode
     * @return array|Bucket[]
     */
    public function findWithActivationExpireWithBalance(
        DateTimeInterface $activationDate,
        DateTimeInterface $expireDate,
        int $balance,
        string $currencyCode
    ): array {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->addSelect('v')
            ->addSelect('c')
            ->join('b.vendor', 'v')
            ->join('b.currency', 'c')
            ->andWhere('b.startDate <= :startDate AND b.endDate >= :endDate AND b.expired = 0 AND b.balance > :balance')
            ->andWhere('c.code = :code')
            ->setParameter('startDate', $activationDate->format('Y-m-d'))
            ->setParameter('endDate', $expireDate->format('Y-m-d'))
            ->setParameter('balance', $balance)
            ->setParameter('code', $currencyCode)
            ->orderBy('b.balance', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Bucket $base
     * @return Bucket
     * @throws NonUniqueResultException
     */
    public function getLatestState(Bucket $base): Bucket
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->addSelect('v')
            ->addSelect('c')
            ->join('b.vendor', 'v')
            ->join('b.currency', 'c')
            ->andWhere('b.base = :base AND b.expired = 0')
            ->setParameter('base', $base)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
