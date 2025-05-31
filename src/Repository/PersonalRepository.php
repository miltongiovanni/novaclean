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

    public function findPersonalByKeysearch($keysearch)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select([
            'p.id',
            $qb->expr()->concat('p.nombre', $qb->expr()->concat($qb->expr()->literal(' '), 'p.apellido')) . ' as nombreCompleto'
        ])
            ->from(Personal::class, 'p')
            ->where($qb->expr()->orX(
                $qb->expr()->like('p.nombre', ':nombresearch'),
                $qb->expr()->like('p.apellido', ':apellidosearch')
            ))
            ->setParameter('nombresearch', '%' . $keysearch . '%')
            ->setParameter('apellidosearch', '%' . $keysearch . '%')
            ->orderBy('p.nombre', 'ASC');
        $query = $qb->getQuery();

// SHOW SQL:
//        echo $query->getSQL();
//// Show Parameters:
//        echo $query->getParameters();
//        die;
        return $query->execute();
    }

    public function getAllPersonal2()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select([
            'p.id',
            'p.nombre',
            'p.apellido',
            'p.slug'
        ])
            ->from(Personal::class, 'p')
            ->orderBy('p.nombre', 'ASC');
        $query = $qb->getQuery();

// SHOW SQL:
//        echo $query->getSQL();
//// Show Parameters:
//        echo $query->getParameters();
//        die;
        return $query->getArrayResult();
    }

    public function getAllPersonal()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT p.id,
               identificacion,
               lugar_expedicion,
               p.nombre,
               apellido,
               numero_cuenta,
               direccion,
               p.telefono,
               correo_electronico,
               p.celular,
               f_nacimiento,
               f_ingreso,
               f_examen_ingreso,
               activo,
               IF(activo, '<i class=\"bi bi-check-circle-fill activo\"></i>', '<i class=\"bi bi-x-circle-fill inactivo\"></i>' ) estado,
               LOWER(CONCAT(
                  SUBSTR(HEX(slug), 1, 8), '-',
                  SUBSTR(HEX(slug), 9, 4), '-',
                  SUBSTR(HEX(slug), 13, 4), '-',
                  SUBSTR(HEX(slug), 17, 4), '-',
                  SUBSTR(HEX(slug), 21)
                )) slug,
               a.nombre      afc,
               a2.nombre     afp,
               e.nombre      eps,
               c.descripcion cargo,
               s.sexo,
               ce.nombre curso_especializado,
               tb.talla talla_botas,
               tc.talla talla_calzado,
               t.talla talla_camisa,
               tg.talla talla_guantes,
               tp.talla talla_pantalon,
               tu.talla talla_uniforme,
               tc2.nombre tipo_cuenta
        FROM personal p
                 LEFT JOIN afc a on p.afc_id = a.id
                 LEFT JOIN afp a2 on a2.id = p.afp_id
                 LEFT JOIN eps e on p.eps_id = e.id
                 LEFT JOIN cargo c on p.cargo_id = c.id
                 LEFT JOIN sexo s on p.sexo_id = s.id
        LEFT JOIN curso_especializado ce on p.curso_especializado_id = ce.id
        LEFT JOIN novaclean.talla_botas tb on p.talla_botas_id = tb.id
        LEFT JOIN novaclean.talla_calzado tc on p.talla_calzado_id = tc.id
        LEFT JOIN novaclean.talla_camisa t on p.talla_camisa_id = t.id
        LEFT JOIN novaclean.talla_guantes tg on p.talla_guantes_id = tg.id
        LEFT JOIN novaclean.talla_pantalon tp on p.talla_pantalon_id = tp.id
        LEFT JOIN novaclean.talla_uniforme tu on p.talla_uniforme_id = tu.id
        LEFT JOIN novaclean.tipo_cuenta tc2 on tc2.id = p.tipo_cuenta_id";

        $resultSet = $conn->executeQuery($sql, []);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
    public function getTotalTablaPersonal($where, $bindings)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT COUNT(*) c
        FROM personal p
                 LEFT JOIN afc a on p.afc_id = a.id
                 LEFT JOIN afp a2 on a2.id = p.afp_id
                 LEFT JOIN eps e on p.eps_id = e.id
                 LEFT JOIN cargo c on p.cargo_id = c.id
                 LEFT JOIN sexo s on p.sexo_id = s.id
        LEFT JOIN curso_especializado ce on p.curso_especializado_id = ce.id
        LEFT JOIN novaclean.talla_botas tb on p.talla_botas_id = tb.id
        LEFT JOIN novaclean.talla_calzado tc on p.talla_calzado_id = tc.id
        LEFT JOIN novaclean.talla_camisa t on p.talla_camisa_id = t.id
        LEFT JOIN novaclean.talla_guantes tg on p.talla_guantes_id = tg.id
        LEFT JOIN novaclean.talla_pantalon tp on p.talla_pantalon_id = tp.id
        LEFT JOIN novaclean.talla_uniforme tu on p.talla_uniforme_id = tu.id
        LEFT JOIN novaclean.tipo_cuenta tc2 on tc2.id = p.tipo_cuenta_id
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
    public function getTablaPersonal( $limit, $order, $where, $bindings)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT p.id,
               identificacion,
               lugar_expedicion,
               p.nombre,
               apellido,
               numero_cuenta,
               direccion,
               p.telefono,
               correo_electronico,
               p.celular,
               f_nacimiento,
               f_ingreso,
               f_examen_ingreso,
               activo,
               IF(activo, '<i class=\"bi bi-check-circle-fill activo\"></i>', '<i class=\"bi bi-x-circle-fill inactivo\"></i>' ) estado,
               LOWER(CONCAT(
                  SUBSTR(HEX(slug), 1, 8), '-',
                  SUBSTR(HEX(slug), 9, 4), '-',
                  SUBSTR(HEX(slug), 13, 4), '-',
                  SUBSTR(HEX(slug), 17, 4), '-',
                  SUBSTR(HEX(slug), 21)
                )) slug,
               a.nombre      afc,
               a2.nombre     afp,
               e.nombre      eps,
               c.descripcion cargo,
               s.sexo,
               ce.nombre curso_especializado,
               tb.talla talla_botas,
               tc.talla talla_calzado,
               t.talla talla_camisa,
               tg.talla talla_guantes,
               tp.talla talla_pantalon,
               tu.talla talla_uniforme,
               tc2.nombre tipo_cuenta
        FROM personal p
                 LEFT JOIN afc a on p.afc_id = a.id
                 LEFT JOIN afp a2 on a2.id = p.afp_id
                 LEFT JOIN eps e on p.eps_id = e.id
                 LEFT JOIN cargo c on p.cargo_id = c.id
                 LEFT JOIN sexo s on p.sexo_id = s.id
        LEFT JOIN curso_especializado ce on p.curso_especializado_id = ce.id
        LEFT JOIN novaclean.talla_botas tb on p.talla_botas_id = tb.id
        LEFT JOIN novaclean.talla_calzado tc on p.talla_calzado_id = tc.id
        LEFT JOIN novaclean.talla_camisa t on p.talla_camisa_id = t.id
        LEFT JOIN novaclean.talla_guantes tg on p.talla_guantes_id = tg.id
        LEFT JOIN novaclean.talla_pantalon tp on p.talla_pantalon_id = tp.id
        LEFT JOIN novaclean.talla_uniforme tu on p.talla_uniforme_id = tu.id
        LEFT JOIN novaclean.tipo_cuenta tc2 on tc2.id = p.tipo_cuenta_id
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

    public function findPersonalByKeysearch2($keysearch)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT p.id, CONCAT(p.nombre, ' ', p.apellido) text
            FROM App\Entity\Personal p
            WHERE p.nombre LIKE :search_nombre OR p.apellido LIKE :search_nombre
            ORDER BY p.nombre ASC"
        )->setParameter('search_nombre', '%' . $keysearch . '%');

        // returns an array of Product objects
        return $query->getResult();
    }

    public function getAllPersonalExport($estado = 1)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT p.id as Id, p.nombre as Nombre, p.apellido as Apellido, p.identificacion as Identificacion
            FROM App\Entity\Personal p
            WHERE p.activo = :estado
            ORDER BY p.nombre ASC"
        )->setParameter('estado', $estado);

        // returns an array of Product objects
        return $query->getResult();
    }

    public function findPersonalDisponibleByKeysearch($keysearch)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT p.id, CONCAT(p.nombre, ' ', p.apellido) as text
                FROM personal p
                LEFT JOIN contrato_personal cp on p.id = cp.personal_id
                WHERE cp.personal_id IS NULL
                AND  (p.nombre LIKE :search_nombre OR p.apellido LIKE :search_nombre)";

        $resultSet = $conn->executeQuery($sql, ['search_nombre' => '%' . $keysearch . '%']);

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
