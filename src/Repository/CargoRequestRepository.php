<?php

namespace App\Repository;

use App\Entity\CargoRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CargoRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method CargoRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method CargoRequest[]    findAll()
 * @method CargoRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CargoRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CargoRequest::class);
    }

    // /**
    //  * @return CargoRequest[] Returns an array of CargoRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CargoRequest
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
