<?php

namespace App\Repository;

use App\Entity\RoadTrainKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoadTrainKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoadTrainKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoadTrainKind[]    findAll()
 * @method RoadTrainKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadTrainKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoadTrainKind::class);
    }

    // /**
    //  * @return RoadTrainKind[] Returns an array of RoadTrainKind objects
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
    public function findOneBySomeField($value): ?RoadTrainKind
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
