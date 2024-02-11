<?php

namespace App\Repository;

use App\Entity\ParametroNomina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParametroNomina>
 *
 * @method ParametroNomina|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParametroNomina|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParametroNomina[]    findAll()
 * @method ParametroNomina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametroNominaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParametroNomina::class);
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
