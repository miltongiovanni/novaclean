<?php

namespace App\Repository;

use App\Entity\TipoNovedadNomina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TipoNovedadNomina>
 *
 * @method TipoNovedadNomina|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoNovedadNomina|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoNovedadNomina[]    findAll()
 * @method TipoNovedadNomina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoNovedadNominaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoNovedadNomina::class);
    }

//    /**
//     * @return TipoNovedadNomina[] Returns an array of TipoNovedadNomina objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TipoNovedadNomina
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
