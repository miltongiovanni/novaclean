<?php

namespace App\Repository;

use App\Entity\DetalleNomina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetalleNomina>
 *
 * @method DetalleNomina|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleNomina|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleNomina[]    findAll()
 * @method DetalleNomina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleNominaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleNomina::class);
    }

//    /**
//     * @return DetalleNomina[] Returns an array of DetalleNomina objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetalleNomina
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
