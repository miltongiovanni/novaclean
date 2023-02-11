<?php

namespace App\Repository;

use App\Entity\TallaCamisa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TallaCamisa>
 *
 * @method TallaCamisa|null find($id, $lockMode = null, $lockVersion = null)
 * @method TallaCamisa|null findOneBy(array $criteria, array $orderBy = null)
 * @method TallaCamisa[]    findAll()
 * @method TallaCamisa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TallaCamisaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TallaCamisa::class);
    }

    public function save(TallaCamisa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TallaCamisa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TallaCamisa[] Returns an array of TallaCamisa objects
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

//    public function findOneBySomeField($value): ?TallaCamisa
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
