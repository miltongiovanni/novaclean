<?php

namespace App\Repository;

use App\Entity\ParametrosNomina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametrosNomina>
 *
 * @method ParametrosNomina|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametrosNomina|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametrosNomina[]    findAll()
 * @method ParametrosNomina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametrosNominaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametrosNomina::class);
    }

//    /**
//     * @return ParametrosNomina[] Returns an array of ParametrosNomina objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ParametrosNomina
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
