<?php

namespace App\Repository;

use App\Entity\Stadium;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function print($min,$max,$state,$date)
    {
        $query = $this->_em->createQuery(
            'SELECT distinct s FROM Stadium s
            inner join reservations r
         on s.id = r.stadium_id
             WHERE s.price>= :priceMin And s.age <= :priceMax and s.state = :state and r.date != :date
             ORDER BY p.age
             ASC'
        )
            ->setParameter('priceMin', $min)
            ->setParameter('priceMax', $max)
            ->setParameter('state', $state)
            ->setParameter('date', $date)
        ;
        return $query->execute();

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
