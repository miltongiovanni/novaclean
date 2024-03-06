<?php

namespace App\Repository;

use App\Entity\Prestamo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prestamo>
 *
 * @method Prestamo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestamo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestamo[]    findAll()
 * @method Prestamo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestamoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestamo::class);
    }

    public function findPrestamos(){
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT p.id, CONCAT(pe.nombre, ' ', pe.apellido) nombre_personal, CONCAT(u.nombre, ' ', u.apellido) nombre_responsable, p.fecha_prestamo, 
                p.estado, p.cuotas, p.monto, IF(ab.no_abonos IS NULL, 0, ab.no_abonos) no_abonos, IF(ab.valor_abonos IS NULL, 0, ab.valor_abonos) valor_abonos, p.monto-IF(ab.valor_abonos IS NULL, 0, ab.valor_abonos) saldo, p.cuotas - IF(ab.no_abonos IS NULL, 0, ab.no_abonos) cuotas_pendientes
                FROM prestamo p
                INNER JOIN personal pe ON p.personal_id= pe.id
                INNER JOIN user u ON p.responsable_id=u.id
                LEFT JOIN (
                SELECT COUNT(*) no_abonos, SUM(abono) valor_abonos, ap.prestamo_id
                FROM abono_prestamo ap
                GROUP BY prestamo_id)ab ON ab.prestamo_id = p.id";

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return Prestamo[] Returns an array of Prestamo objects
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

//    public function findOneBySomeField($value): ?Prestamo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
