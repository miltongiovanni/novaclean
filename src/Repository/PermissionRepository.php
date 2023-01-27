<?php

namespace App\Repository;

use App\Entity\Permission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Permission>
 *
 * @method Permission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permission[]    findAll()
 * @method Permission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permission::class);
    }

    public function save(Permission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Permission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Permission[] Returns an array of Permission objects
     */
    public function findByPerfilId($value): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.perfil', 'pe','WITH', 'pe.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
     * @return Permission[] Returns an array of Permission objects
     */
    public function findOneByPerfilId($value, $atributo, $modulo): ?Permission
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.perfil', 'pe','WITH', 'pe.id = :val')
            ->andWhere('p.perfil = :val')
            ->andWhere('p.atributo = :atributo')
            ->andWhere('p.modulo = :modulo')
            ->setParameter('val', $value)
            ->setParameter('atributo', $atributo)
            ->setParameter('modulo', $modulo)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    public function findOneBySomeField($value): ?Permission
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
