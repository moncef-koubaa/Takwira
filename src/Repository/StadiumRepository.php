<?php

namespace App\Repository;

use App\Entity\Stadium;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;

/**
 * @extends ServiceEntityRepository<Stadium>
 *
 * @method Stadium|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stadium|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stadium[]    findAll()
 * @method Stadium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StadiumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stadium::class);
    }

    public function print($min, $max, $state, $date, $name, $pageNumber, $pageSize=6)
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.reservations', 'r')
            ->andWhere('s.pricePerHour >= :priceMin')
            ->setParameter('priceMin', $min)
            ->andWhere('s.pricePerHour <= :priceMax')
            ->setParameter('priceMax', $max)
            ->andWhere('r.date != :date')
            ->setParameter('date', $date);

        if ($state != null) {
            $qb->andWhere('s.city = :state')
                ->setParameter('state', $state);
        }
        if ($name !== null) {
            $qb->andWhere('s.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        // Count total results
        $countQb = clone $qb;
        $totalResults = (int)$countQb->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // Paginate results
        $paginator = new Paginator($qb);
        $paginator
            ->getQuery()
            ->setFirstResult(($pageNumber - 1) * $pageSize)
            ->setMaxResults($pageSize);

        return [
            'results' => $paginator->getIterator()->getArrayCopy(),
            'totalResults' => $totalResults,
            'currentPage' => $pageNumber,
            'pageSize' => $pageSize,
        ];
    }


    //    /**
    //     * @return Stadium[] Returns an array of Stadium objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Stadium
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
