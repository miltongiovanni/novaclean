<?php

namespace App\Controller;

use App\Entity\Personal;
use App\Entity\Prestamo;
use App\Form\PersonalType;
use App\Repository\AfcRepository;
use App\Repository\AfpRepository;
use App\Repository\CargoRepository;
use App\Repository\CursoEspecializadoRepository;
use App\Repository\EpsRepository;
use App\Repository\PersonalRepository;
use App\Repository\PrestamoRepository;
use App\Repository\SexoRepository;
use App\Repository\TallaBotasRepository;
use App\Repository\TallaCalzadoRepository;
use App\Repository\TallaCamisaRepository;
use App\Repository\TallaGuantesRepository;
use App\Repository\TallaPantalonRepository;
use App\Repository\TallaUniformeRepository;
use App\Repository\TipoCuentaRepository;
use App\Repository\TipoNominaRepository;
use App\Service\DataTablesServerSide;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/personal')]
class PersonalController extends AbstractController
{
    private PersonalRepository $personalRepository;
    private PrestamoRepository $prestamoRepository;


    public function __construct(PersonalRepository $personalRepository, PrestamoRepository $prestamoRepository)
    {
        $this->personalRepository = $personalRepository;
        $this->prestamoRepository = $prestamoRepository;
    }

    #[Route('/', name: 'personal_index', methods: ['GET'])]
    public function index(): Response
    {
        $rutaListaPersonal = $this->generateUrl('personal_lista');

        return $this->render('personal/index.html.twig', [
            'personals' => $this->personalRepository->findAll(),
        ]);
    }

    #[Route('/nuevo/', name: 'personal_new', methods: ['GET', 'POST'])]
    public function new(Request                      $request, SexoRepository $sexoRepository, TipoNominaRepository $tipoNominaRepository, AfpRepository $afpRepository,
                        EpsRepository                $epsRepository, AfcRepository $afcRepository, TipoCuentaRepository $tipoCuentaRepository, TallaUniformeRepository $tallaUniformeRepository,
                        TallaBotasRepository         $tallaBotasRepository, CargoRepository $cargoRepository, TallaGuantesRepository $tallaGuantesRepository,
                        CursoEspecializadoRepository $cursoEspecializadoRepository, TallaCamisaRepository $tallaCamisaRepository, TallaPantalonRepository $tallaPantalonRepository,
                        TallaCalzadoRepository       $tallaCalzadoRepository): Response
    {
        $sexos = $sexoRepository->findAll();
        $afps = $afpRepository->findAll();
        $epss = $epsRepository->findAll();
        $afcs = $afcRepository->findAll();
        $tiposCuenta = $tipoCuentaRepository->findAll();
        $tallasUniforme = $tallaUniformeRepository->findAll();
        $tallasBotas = $tallaBotasRepository->findAll();
        $cargos = $cargoRepository->findAll();
        $tallasGuantes = $tallaGuantesRepository->findAll();
        $cursosEspecializados = $cursoEspecializadoRepository->findAll();
        $tallasCamisa = $tallaCamisaRepository->findAll();
        $tallasPantalon = $tallaPantalonRepository->findAll();
        $tallasCalzado = $tallaCalzadoRepository->findAll();
        $slug = Uuid::v6();
        return $this->render('personal/new.html.twig', [
            'action' => 'insert',
            'sexos' => $sexos,
            'afps' => $afps,
            'epss' => $epss,
            'afcs' => $afcs,
            'tiposCuenta' => $tiposCuenta,
            'tallasUniforme' => $tallasUniforme,
            'tallasBotas' => $tallasBotas,
            'cargos' => $cargos,
            'tallasGuantes' => $tallasGuantes,
            'cursosEspecializados' => $cursosEspecializados,
            'tallasCamisa' => $tallasCamisa,
            'tallasPantalon' => $tallasPantalon,
            'tallasCalzado' => $tallasCalzado,
            'slug' => $slug,
        ]);
    }

    #[Route('/{slug}/ver', name: 'personal_show', methods: ['GET'])]
    public function show(string $slug): Response
    {
        $personal = $this->personalRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        return $this->render('personal/show.html.twig', [
            'personal' => $personal,
        ]);
    }

    #[Route('/lista/', name: 'personal_lista', methods: ['POST'])]
    public function lista(): JsonResponse
    {
        $columns = array(
            array('db' => 'p.nombre', 'dt' => 'nombre'),
            array('db' => 'p.apellido', 'dt' => 'apellido'),
            array('db' => 'identificacion', 'dt' => 'identificacion'),
            array('db' => 'lugar_expedicion', 'dt' => 'lugar_expedicion'),
            array('db' => 'f_ingreso', 'dt' => 'f_ingreso'),
            array('db' => 'c.descripcion', 'dt' => 'cargo'),
            array('db' => 'estado', 'dt' => 'estado'),
        );
        $bindings = array();
        $limit = DataTablesServerSide::limit($_POST, $columns);
        $order = DataTablesServerSide::order($_POST, $columns);
        $where = DataTablesServerSide::filter($_POST, $columns, $bindings);

        $totalPersonal = $this->personalRepository->getTotalTablaPersonal($where, $bindings);
        $personal = $this->personalRepository->getTablaPersonal($limit, $order, $where, $bindings);
        $return = [
            "draw"            => isset ( $_POST['draw'] ) ?
                intval( $_POST['draw'] ) :
                0,
            'recordsTotal' => $totalPersonal,
            'recordsFiltered' => $totalPersonal,
            'data' => $personal
        ];

        return $this->json($return);
    }

    #[Route('/{slug}/editar/', name: 'personal_edit', methods: ['GET'])]
    public function edit(Request                      $request, string $slug, SexoRepository $sexoRepository, AfpRepository $afpRepository,
                         EpsRepository                $epsRepository, AfcRepository $afcRepository, TipoCuentaRepository $tipoCuentaRepository, TallaUniformeRepository $tallaUniformeRepository,
                         TallaBotasRepository         $tallaBotasRepository, CargoRepository $cargoRepository, TallaGuantesRepository $tallaGuantesRepository,
                         CursoEspecializadoRepository $cursoEspecializadoRepository, TallaCamisaRepository $tallaCamisaRepository, TallaPantalonRepository $tallaPantalonRepository,
                         TallaCalzadoRepository       $tallaCalzadoRepository): Response
    {
        $personal = $this->personalRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $sexos = $sexoRepository->findAll();
        $afps = $afpRepository->findAll();
        $epss = $epsRepository->findAll();
        $afcs = $afcRepository->findAll();
        $tiposCuenta = $tipoCuentaRepository->findAll();
        $tallasUniforme = $tallaUniformeRepository->findAll();
        $tallasBotas = $tallaBotasRepository->findAll();
        $cargos = $cargoRepository->findAll();
        $tallasGuantes = $tallaGuantesRepository->findAll();
        $cursosEspecializados = $cursoEspecializadoRepository->findAll();
        $tallasCamisa = $tallaCamisaRepository->findAll();
        $tallasPantalon = $tallaPantalonRepository->findAll();
        $tallasCalzado = $tallaCalzadoRepository->findAll();


        return $this->render('personal/edit.html.twig', [
            'personal' => $personal,
            'action' => 'update',
            'sexos' => $sexos,
            'afps' => $afps,
            'epss' => $epss,
            'afcs' => $afcs,
            'tiposCuenta' => $tiposCuenta,
            'tallasUniforme' => $tallasUniforme,
            'tallasBotas' => $tallasBotas,
            'cargos' => $cargos,
            'tallasGuantes' => $tallasGuantes,
            'cursosEspecializados' => $cursosEspecializados,
            'tallasCamisa' => $tallasCamisa,
            'tallasPantalon' => $tallasPantalon,
            'tallasCalzado' => $tallasCalzado,
        ]);
    }


    #[Route('/{slug}/actualizar/', name: 'personal_update', methods: ['POST'])]
    public function update(Request               $request, string $slug, PersonalRepository $personalRepository, EntityManagerInterface $entityManager, SexoRepository $sexoRepository,
                           AfpRepository $afpRepository, EpsRepository $epsRepository, AfcRepository $afcRepository,
                           TipoCuentaRepository  $tipoCuentaRepository, TallaUniformeRepository $tallaUniformeRepository, TallaBotasRepository $tallaBotasRepository,
                           CargoRepository       $cargoRepository, TallaGuantesRepository $tallaGuantesRepository, CursoEspecializadoRepository $cursoEspecializadoRepository,
                           TallaCamisaRepository $tallaCamisaRepository, TallaPantalonRepository $tallaPantalonRepository, TallaCalzadoRepository $tallaCalzadoRepository): Response
    {
        $personal = $personalRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        if (!$personal){
            $personal = new Personal();
            $personal->setSlug(Uuid::fromString($slug));
        }
        $action = $request->request->get('action');
        $personal->setNombre(trim($request->request->get('nombre')));
        $personal->setActivo(trim($request->request->get('activo')));
        $telefono = trim($request->request->get('telefono'));
        $personal->setTelefono($telefono != '' ? $telefono : null);
        $personal->setApellido(trim($request->request->get('apellido')));
        $personal->setDireccion(trim($request->request->get('direccion')));
        $personal->setIdentificacion(trim($request->request->get('identificacion')));
        $personal->setLugarExpedicion(trim($request->request->get('lugar_expedicion')));
        $personal->setFNacimiento(Carbon::createFromFormat('Y-m-d', trim($request->request->get('fNacimiento'))));
        $celular = trim($request->request->get('celular'));
        $personal->setCelular($celular != '' ? $celular : null);
        $correo_electronico = trim($request->request->get('correo_electronico'));
        $personal->setCorreoElectronico($correo_electronico != '' ? $correo_electronico : null);
        $personal->setSexo($sexoRepository->find(trim($request->request->get('sexo'))));
        $personal->setAfp($afpRepository->find(trim($request->request->get('afp'))));
        $personal->setAfc($afcRepository->find(trim($request->request->get('afc'))));
        $personal->setEps($epsRepository->find(trim($request->request->get('eps'))));
        $personal->setUser($this->getUser());
        $f_examen_ingreso = $request->request->get('f_examen_ingreso');
        if ($f_examen_ingreso != '') {
            $personal->setFExamenIngreso(Carbon::createFromFormat('Y-m-d', $f_examen_ingreso));
        }
        $personal->setFIngreso(Carbon::createFromFormat('Y-m-d', trim($request->request->get('f_ingreso'))));
        $personal->setTipoCuenta($tipoCuentaRepository->find(trim($request->request->get('tipo_cuenta'))));
        $personal->setNumeroCuenta(trim($request->request->get('numero_cuenta')));
        $personal->setCargo($cargoRepository->find(trim($request->request->get('cargo'))));
        $talla_camisa = $request->request->get('talla_camisa');
        if ($talla_camisa != null) {
            $personal->setTallaCamisa($tallaCamisaRepository->find($talla_camisa));
        }
        $talla_uniforme = $request->request->get('talla_uniforme');
        if ($talla_uniforme != null) {
            $personal->setTallaUniforme($tallaUniformeRepository->find($talla_uniforme));
        }
        $talla_botas = $request->request->get('talla_botas');
        if ($talla_botas != null) {
            $personal->setTallaBotas($tallaBotasRepository->find($talla_botas));
        }
        $talla_guantes = $request->request->get('talla_guantes');
        if ($talla_guantes != null) {
            $personal->setTallaGuantes($tallaGuantesRepository->find($talla_guantes));
        }
        $talla_pantalon = $request->request->get('talla_pantalon');
        if ($talla_pantalon != null) {
            $personal->setTallaPantalon($tallaPantalonRepository->find($talla_pantalon));
        }
        $talla_calzado = $request->request->get('talla_calzado');
        if ($talla_calzado != null) {
            $personal->setTallaCalzado($tallaCalzadoRepository->find($talla_calzado));
        }
        $curso_especializado = $request->request->get('curso_especializado');
        if ($curso_especializado != null) {
            $personal->setCursoEspecializado($cursoEspecializadoRepository->find($curso_especializado));
        }

        $coorserpark = trim($request->request->get('coorserpark'));
        $personal->setCoorserpark($coorserpark != '' ? $coorserpark : null);

        if ($action == 'insert') {
            $personal->setFechaCreacion(Carbon::now());
        }
        $personal->setFechaActualizacion(Carbon::now());

        $entityManager->persist($personal);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Personal creado correctamente');
        } else {
            $this->addFlash('success', 'Personal actualizado correctamente');
        }
        return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{slug}/activar/', name: 'personal_activate', methods: ['GET'])]
    public function activate(Request $request, string $slug, EntityManagerInterface $entityManager, PersonalRepository $personalRepository): Response
    {
        $personal = $personalRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $personal->setActivo(true);
        $entityManager->persist($personal);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Personal activado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Usuario');
        return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/{slug}/desactivar/', name: 'personal_deactivate', methods: ['GET'])]
    public function deactivate(Request $request, string $slug, EntityManagerInterface $entityManager, PersonalRepository $personalRepository): Response
    {
        $personal = $personalRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $personal->setActivo(false);
        $entityManager->persist($personal);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Personal desactivado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Usuario');
        return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/{slug}/borrar/', name: 'personal_delete', methods: ['POST'])]
    public function delete(Request $request, string $slug, PersonalRepository $personalRepository): Response
    {
        $personal = $this->personalRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        if ($this->isCsrfTokenValid('delete' . $personal->getId(), $request->request->get('_token'))) {
            $personalRepository->remove($personal, true);
        }

        return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{idContrato}/lista/', name: 'personal_contrato_lista', methods: ['POST'])]
    public function lista_contrato(): JsonResponse
    {
        $personals = $this->personalRepository->findAll();
        $personalsToArray = [];
        foreach ($personals as $key => $personal) {
            $personalsToArray[$key] = $personal->toArray();
            $personalsToArray[$key]['estado'] = $personalsToArray[$key]['activo'] == true ? '<i class="bi bi-check-circle-fill activo"></i>' : '<i class="bi bi-x-circle-fill inactivo"></i>';
            $personalsToArray[$key]['actions'] = $this->renderView('personal/_personal.buttons.html.twig', ['empleado' => $personalsToArray[$key]]);
        }

        //To array
//        $personalsToArray = array_map(function ($personal) {
//            /** @var Personal $personal */
//            $arr = $personal->toArray();
//            return $arr;
//        }, $personals);
        $return = [
            'draw' => 0,
            'recordsTotal' => count($personalsToArray),
            'recordsFiltered' => count($personalsToArray),
            'data' => $personalsToArray
        ];

        return $this->json($return);
    }


    #[Route('/prestamo/', name: 'prestamo_personal_index', methods: ['GET'])]
    public function prestamo_index(): Response
    {
        $prestamos = $this->prestamoRepository->findPrestamos();
        return $this->render('personal/prestamo_index.html.twig', [
            'prestamos' => $prestamos,
        ]);
    }
    #[Route('/prestamo/nuevo/', name: 'prestamo_personal_new', methods: ['GET', 'POST'])]
    public function prestamo_personal_new(Request $request): Response
    {

        return $this->render('personal/prestamo_new.html.twig', [
            'action' => 'insert',
            'id' => 0,
        ]);
    }

    #[Route('/prestamo/{id}/editar/', name: 'prestamo_personal_edit', methods: ['GET'])]
    public function prestamo_personal_edit(Request $request, int $id): Response
    {
        $prestamo = $this->prestamoRepository->find($id);
        return $this->render('personal/prestamo_edit.html.twig', [
            'prestamo' => $prestamo,
            'id' => $id,
            'action' => 'update',
        ]);
    }


    #[Route('/prestamo/{id}/actualizar/', name: 'prestamo_personal_update', methods: ['POST'])]
    public function prestamo_personal_update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $personal_id = trim($request->request->get('personal_id'));
        $personal = $this->personalRepository->find($personal_id);

        $prestamo = $this->prestamoRepository->find($id);
        if (!$prestamo){
            $prestamo = new Prestamo();
        }
        $prestamo->setPersonal($personal);
        $prestamo->setFechaPrestamo(Carbon::createFromFormat('Y-m-d', trim($request->request->get('fecha_prestamo'))));
        $prestamo->setMonto(trim($request->request->get('monto')));
        $prestamo->setResponsable($this->getUser());
        $prestamo->setEstado(true);
        $prestamo->setCuotas(trim($request->request->get('cuotas')));
        $action = $request->request->get('action');

        $entityManager->persist($prestamo);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Préstamo creado correctamente');
        } else {
            $this->addFlash('success', 'Préstamo actualizado correctamente');
        }
        return $this->redirectToRoute('prestamo_personal_index', [], Response::HTTP_SEE_OTHER);
    }


}
