<?php

namespace App\Repository;

use App\Entity\NovedadNomina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NovedadNomina>
 *
 * @method NovedadNomina|null find($id, $lockMode = null, $lockVersion = null)
 * @method NovedadNomina|null findOneBy(array $criteria, array $orderBy = null)
 * @method NovedadNomina[]    findAll()
 * @method NovedadNomina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NovedadNominaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NovedadNomina::class);
    }

//    /**
//     * @return NovedadesNomina[] Returns an array of NovedadesNomina objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NovedadesNomina
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
