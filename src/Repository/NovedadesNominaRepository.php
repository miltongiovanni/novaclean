<?php

namespace App\Repository;

use App\Entity\NovedadesNomina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NovedadesNomina>
 *
 * @method NovedadesNomina|null find($id, $lockMode = null, $lockVersion = null)
 * @method NovedadesNomina|null findOneBy(array $criteria, array $orderBy = null)
 * @method NovedadesNomina[]    findAll()
 * @method NovedadesNomina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NovedadesNominaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NovedadesNomina::class);
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
