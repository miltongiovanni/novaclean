<?php

namespace App\Repository;

use App\Entity\TallaCalzado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TallaCalzado>
 *
 * @method TallaCalzado|null find($id, $lockMode = null, $lockVersion = null)
 * @method TallaCalzado|null findOneBy(array $criteria, array $orderBy = null)
 * @method TallaCalzado[]    findAll()
 * @method TallaCalzado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TallaCalzadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TallaCalzado::class);
    }

    public function save(TallaCalzado $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TallaCalzado $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TallaCalzado[] Returns an array of TallaCalzado objects
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

//    public function findOneBySomeField($value): ?TallaCalzado
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
