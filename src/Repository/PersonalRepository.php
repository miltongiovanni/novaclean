<?php

namespace App\Repository;

use App\Entity\Personal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personal>
 *
 * @method Personal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personal[]    findAll()
 * @method Personal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personal::class);
    }

    public function save(Personal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Personal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPersonalByKeysearch($keysearch){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select([
            'p.id',
            $qb->expr()->concat('p.nombre', $qb->expr()->concat($qb->expr()->literal(' '), 'p.apellido')).' as nombreCompleto'
        ])
            ->from(Personal::class, 'p')
            ->where($qb->expr()->orX(
                $qb->expr()->like('p.nombre', ':nombresearch'),
                $qb->expr()->like('p.apellido', ':apellidosearch')
            ))
            ->setParameter('nombresearch', '%'.$keysearch.'%')
            ->setParameter('apellidosearch', '%'.$keysearch.'%')
            ->orderBy('p.nombre', 'ASC');
        $query = $qb->getQuery();

// SHOW SQL:
//        echo $query->getSQL();
//// Show Parameters:
//        echo $query->getParameters();
//        die;
        return $query->execute();
    }

    public function findPersonalByKeysearch2($keysearch){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT p.id, CONCAT(p.nombre, ' ', p.apellido) text
            FROM App\Entity\Personal p
            WHERE p.nombre LIKE :search_nombre OR p.apellido LIKE :search_nombre
            ORDER BY p.nombre ASC"
        )->setParameter('search_nombre', '%'.$keysearch.'%');

        // returns an array of Product objects
        return $query->getResult();
    }
    public function findPersonalDisponibleByKeysearch($keysearch){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT p.id, CONCAT(p.nombre, ' ', p.apellido) as text
                FROM personal p
                LEFT JOIN contrato_personal cp on p.id = cp.personal_id
                WHERE cp.personal_id IS NULL
                AND  (p.nombre LIKE :search_nombre OR p.apellido LIKE :search_nombre)";

        $resultSet = $conn->executeQuery($sql, ['search_nombre' => '%'.$keysearch.'%']);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
//    /**
//     * @return Personal[] Returns an array of Personal objects
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

//    public function findOneBySomeField($value): ?Personal
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
