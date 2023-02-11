<?php

namespace App\Repository;

use App\Entity\CursoEspecializado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CursoEspecializado>
 *
 * @method CursoEspecializado|null find($id, $lockMode = null, $lockVersion = null)
 * @method CursoEspecializado|null findOneBy(array $criteria, array $orderBy = null)
 * @method CursoEspecializado[]    findAll()
 * @method CursoEspecializado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CursoEspecializadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CursoEspecializado::class);
    }

    public function save(CursoEspecializado $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CursoEspecializado $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CursoEspecializado[] Returns an array of CursoEspecializado objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CursoEspecializado
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
