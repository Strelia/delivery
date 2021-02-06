<?php

namespace App\Repository;

use App\Entity\PaymentKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentKind[]    findAll()
 * @method PaymentKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentKind::class);
    }

    // /**
    //  * @return PaymentKind[] Returns an array of PaymentKind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PaymentKind
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
