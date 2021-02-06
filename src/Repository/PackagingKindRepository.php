<?php

namespace App\Repository;

use App\Entity\PackagingKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PackagingKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackagingKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackagingKind[]    findAll()
 * @method PackagingKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackagingKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackagingKind::class);
    }

    // /**
    //  * @return PackagingKind[] Returns an array of PackagingKind objects
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
    public function findOneBySomeField($value): ?PackagingKind
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
