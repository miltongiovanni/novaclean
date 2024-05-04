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

    public function getTotalTablaNovedadesNomina($where, $bindings)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT COUNT(*) c
                FROM novedad_nomina nn
                    LEFT JOIN personal p on p.id = nn.personal_id
                    LEFT JOIN tipo_novedad_nomina tnn on nn.tipo_novedad_id = tnn.id
                $where
                ";
        $params = [];
        // Bind parameters
        if (is_array($bindings)){
            foreach ($bindings as $key => $binding) {
                $params[ltrim($binding['key'], $binding['key'][0] )] = $binding['val'];
            }
        }
        $resultSet = $conn->executeQuery($sql, $params);
        $result = $resultSet->fetchAssociative();
        return $result['c'];
    }
    public function getTablaNovedadesNomina( $limit, $order, $where, $bindings)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT nn.id,
                       nn.personal_id,
                       CONCAT(p.nombre, ' ', p.apellido) personal,
                       nn.tipo_novedad_id,
                       tnn.descripcion tipo_novedad,
                       IF(tipo_novedad_id =7 or tipo_novedad_id =8, LOWER(DATE_FORMAT(nn.fecha_inicio, '%d-%m-%Y %l:%i %p')), DATE_FORMAT(nn.fecha_inicio, '%d-%m-%Y')) f_inicio,
                       IF(tipo_novedad_id =7 or tipo_novedad_id =8, LOWER(DATE_FORMAT(nn.fecha_fin, '%d-%m-%Y %l:%i %p')), DATE_FORMAT(nn.fecha_fin, '%d-%m-%Y')) f_fin,
                       nn.observaciones,
                       nn.activa,
                       IF(activa, '<i class=\"bi bi-check-circle-fill activo\"></i>', '<i class=\"bi bi-x-circle-fill inactivo\"></i>' ) estado,
                       DATE_FORMAT(nn.fecha_creacion, '%d-%m-%Y') f_creacion,
                       DATE_FORMAT(nn.fecha_actualizacion, '%d-%m-%Y') f_actualizacion
                FROM novedad_nomina nn
                    LEFT JOIN personal p on p.id = nn.personal_id
                    LEFT JOIN tipo_novedad_nomina tnn on nn.tipo_novedad_id = tnn.id
                $where
                $order
                $limit
                ";
        $params = [];
        // Bind parameters
        if (is_array($bindings)){
            foreach ($bindings as $key => $binding) {
                $params[ltrim($binding['key'], $binding['key'][0] )] = $binding['val'];
            }
        }

        $resultSet = $conn->executeQuery($sql, $params);
        // Execute
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
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
