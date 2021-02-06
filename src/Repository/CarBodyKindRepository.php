<?php

namespace App\Repository;

use App\Entity\CarBodyKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarBodyKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarBodyKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarBodyKind[]    findAll()
 * @method CarBodyKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarBodyKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarBodyKind::class);
    }

    // /**
    //  * @return CarBodyKind[] Returns an array of CarBodyKind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarBodyKind
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
