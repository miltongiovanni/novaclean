<?php

namespace App\Repository;

use App\Entity\Contrato;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contrato>
 *
 * @method Contrato|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contrato|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contrato[]    findAll()
 * @method Contrato[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrato::class);
    }

    public function save(Contrato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contrato $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getAllContratos()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT c.id,
               c.n_contrato contrato_id,
               c.f_inicio,
               c.f_fin,
               c.poliza_salario tiene_poliza_salario,
               c.poliza_cumplimiento tiene_poliza_cumplimient,
               c.n_poliza no_poliza,
               c.aseguradora,
               c.vencimiento_poliza,
               c.observaciones,
               LOWER(CONCAT(
                       SUBSTR(HEX(c.slug), 1, 8), '-',
                       SUBSTR(HEX(c.slug), 9, 4), '-',
                       SUBSTR(HEX(c.slug), 13, 4), '-',
                       SUBSTR(HEX(c.slug), 17, 4), '-',
                       SUBSTR(HEX(c.slug), 21)
                     )) slug,
               IF(f_fin> now(), '<i class=\"bi bi-check-circle-fill activo\"></i>', '<i class=\"bi bi-x-circle-fill inactivo\"></i>' ) estado,
               c2.nombre cliente,
               p.nombre supervisor
        FROM contrato c
                 LEFT JOIN cliente c2 on c2.id = c.cliente_id
        LEFT JOIN novaclean.personal p on p.id = c.personal_id";

        $resultSet = $conn->executeQuery($sql, []);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return Contrato[] Returns an array of Contrato objects
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

//    public function findOneBySomeField($value): ?Contrato
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
