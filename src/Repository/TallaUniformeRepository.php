<?php

namespace App\Repository;

use App\Entity\TallaUniforme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TallaUniforme>
 *
 * @method TallaUniforme|null find($id, $lockMode = null, $lockVersion = null)
 * @method TallaUniforme|null findOneBy(array $criteria, array $orderBy = null)
 * @method TallaUniforme[]    findAll()
 * @method TallaUniforme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TallaUniformeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TallaUniforme::class);
    }

    public function save(TallaUniforme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TallaUniforme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TallaUniforme[] Returns an array of TallaUniforme objects
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

//    public function findOneBySomeField($value): ?TallaUniforme
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
