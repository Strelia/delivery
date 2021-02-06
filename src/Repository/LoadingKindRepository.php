<?php

namespace App\Repository;

use App\Entity\LoadingKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LoadingKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoadingKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoadingKind[]    findAll()
 * @method LoadingKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoadingKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoadingKind::class);
    }

    // /**
    //  * @return LoadingKind[] Returns an array of LoadingKind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LoadingKind
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
