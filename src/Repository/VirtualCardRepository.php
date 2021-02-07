<?php

namespace VirtualCard\Repository;

use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use VirtualCard\Entity\Currency;
use VirtualCard\Entity\Vendor;
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
            ->getOneOrNullResult();
    }

    public function list(array $parameters): Query
    {
        $qb = $this->createQueryBuilder('v')
            ->select('v')
            ->addSelect('c')
            ->join('v.currency', 'c')
            ->join('v.baseBucket', 'bb');

        if ($parameters['currency'] instanceof Currency) {
            $qb
                ->andWhere('v.currency = :currency')
                ->setParameter('currency', $parameters['currency']);
        }

        if ($parameters['vendor'] instanceof Vendor) {
            $qb
                ->andWhere('bb.vendor = :vendor')
                ->setParameter('vendor', $parameters['vendor']);
        }

        if ($parameters['activationDateFrom'] instanceof DateTimeInterface) {
            $qb
                ->andWhere('v.activationDate >= :activationFrom')
                ->setParameter('activationFrom', $parameters['activationDateFrom']->format('Y-m-d'));
        }

        if ($parameters['activationDateTo'] instanceof DateTimeInterface) {
            $qb
                ->andWhere('v.activationDate <= :activationTo')
                ->setParameter('activationTo', $parameters['activationDateTo']->format('Y-m-d'));
        }

        return $qb->getQuery();
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
