<?php

namespace VirtualCard\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use VirtualCard\Entity\VirtualCard;

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
    
    /**
     * @param string $reference
     * @return VirtualCard|null
     * @throws NonUniqueResultException
     */
    public function findVirtualCardByRef(string $reference): ?VirtualCard
    {
        return $this->createQueryBuilder('v')
            ->select('v')
            ->addSelect('bb')
            ->addSelect('c')
            ->join('v.baseBucket', 'bb')
            ->join('v.currency', 'c')
            ->andWhere('v.reference = :ref')
            ->setParameter('ref', $reference)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    /**
     * @param VirtualCard $virtualCard
     * @throws ORMException
     */
    public function remove(VirtualCard $virtualCard): void
    {
        $this->_em->remove($virtualCard);
    }
}
