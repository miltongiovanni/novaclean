<?php

namespace App\Repository;

use App\Entity\AbonoPrestamo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbonoPrestamo>
 *
 * @method AbonoPrestamo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbonoPrestamo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbonoPrestamo[]    findAll()
 * @method AbonoPrestamo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonoPrestamoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbonoPrestamo::class);
    }

//    /**
//     * @return AbonoPrestamo[] Returns an array of AbonoPrestamo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AbonoPrestamo
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
