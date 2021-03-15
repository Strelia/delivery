<?php

namespace App\Repository;

use App\Entity\Business;
use App\Entity\Cargo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cargo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cargo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cargo[]    findAll()
 * @method Cargo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CargoRepository extends ServiceEntityRepository
{
    const PAGINATOR_PER_PAGE = 20;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cargo::class);
    }

    public function getAllCargo(int $offset, ?array $statuses): QueryBuilder
    {
        $builder = $this->createQueryBuilder('c');

        if ($statuses) {
            $builder->andWhere('c.status NOT IN  (:statuses)')
                ->setParameter('statuses', $statuses);
        }
        $builder->setFirstResult($offset);


        return $builder;
    }

    public function getQueryBuildCargoByBusiness(Business $business, int $offset): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.owner = :business')
            ->andWhere('c.status IN  (:statuses)')
            ->setParameter('business', $business)
            ->setParameter('statuses', [Cargo::STATUS_CLOSE, Cargo::STATUS_OPEN])
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset);
    }

    public function getPaginator(QueryBuilder $query): Paginator
    {
        $query
            ->setMaxResults(self::PAGINATOR_PER_PAGE);
        return new Paginator($query->getQuery());
    }

    // /**
    //  * @return Cargo[] Returns an array of Cargo objects
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
    public function findOneBySomeField($value): ?Cargo
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
