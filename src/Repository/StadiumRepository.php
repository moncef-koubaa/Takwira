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
    public function nbReservation($stadiumName)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s.openingTime, s.closingTime')
            ->andWhere('s.name = :name')
            ->setParameter('name', $stadiumName);

        $result = $qb->getQuery()->getOneOrNullResult();

        if (!$result) {
            // Handle the case where no stadium is found with the given name
            return 0;
        }

        $openingTime = $result['openingTime']->getTimestamp();
        $closingTime = $result['closingTime']->getTimestamp();
        $diffInSeconds = $closingTime - $openingTime;
        $diffInHours = $diffInSeconds / 3600; // Convert seconds to hours
        return $diffInHours;
    }





    public function famaBlasa($stadiumName, $date): bool
    {
        $qb = $this->createQueryBuilder('s')
            ->select('r.startTime, r.endTime')
            ->innerJoin('s.reservations', 'r')
            ->andWhere('s.name = :name')->setParameter('name', $stadiumName)
            ->andWhere('r.date = :date')->setParameter('date', $date);

        $results = $qb->getQuery()->getResult();
        //dump($results);

        $totalSeconds = 0;
        foreach ($results as $result) {
            $startTime = $result['startTime']->getTimestamp();
            $endTime = $result['endTime']->getTimestamp();
            var_dump("start",$startTime,"end", $endTime);
            $totalSeconds += ($endTime - $startTime);
        }

        $totalHours = $totalSeconds / 3600; // Convert seconds to hours
        // die();
        return $totalHours < $this->nbReservation($stadiumName);
    }





    /**
     * @throws \Exception
     */
    public function print($min, $max, $state, $date, $name, $pageNumber, $pageSize=6)
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.reservations', 'r')
            ->andWhere('s.pricePerHour >= :priceMin')
            ->setParameter('priceMin', $min)
            ->andWhere('s.pricePerHour <= :priceMax')
            ->setParameter('priceMax', $max);
//            ->andWhere('r.date != :date or ')
//            ->setParameter('date', $date);

        if ($state != null) {
            $qb->andWhere('s.city = :state')
                ->setParameter('state', $state);
        }
        if ($name !== null) {
            $qb->andWhere('s.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        // Count total results
//        $countQb = clone $qb;
//        $totalResults = (int)$countQb->select('COUNT(s.id)')
//            ->getQuery()
//            ->getSingleScalarResult();
        // Paginate results



        $paginator = new Paginator($qb);
//        $paginator
//            ->getQuery()
//            ->setFirstResult(($pageNumber - 1) * $pageSize)
//            ->setMaxResults($pageSize);
        $totalResults = count($paginator);
        $nb=0;
        $stadiums=$paginator->getIterator()->getArrayCopy();
        $filteredStadiums = [];


        foreach ($stadiums as $stadium) {
            if ($this->famaBlasa($stadium->getName(), $date)) {
                $filteredStadiums[] = $stadium;
                $nb=$nb+1;
            }}

        return [
            'results' => $filteredStadiums,
            'totalResults' => $nb,
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
