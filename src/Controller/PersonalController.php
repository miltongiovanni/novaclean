<?php

namespace App\Controller;

use App\Entity\Personal;
use App\Form\PersonalType;
use App\Repository\AfcRepository;
use App\Repository\AfpRepository;
use App\Repository\CargoRepository;
use App\Repository\CursoEspecializadoRepository;
use App\Repository\EpsRepository;
use App\Repository\PersonalRepository;
use App\Repository\SexoRepository;
use App\Repository\TallaBotasRepository;
use App\Repository\TallaCalzadoRepository;
use App\Repository\TallaCamisaRepository;
use App\Repository\TallaGuantesRepository;
use App\Repository\TallaPantalonRepository;
use App\Repository\TallaUniformeRepository;
use App\Repository\TipoCuentaRepository;
use App\Repository\TipoNominaRepository;
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

    public function __construct(PersonalRepository $personalRepository)
    {
        $this->personalRepository = $personalRepository;
    }

    #[Route('/', name: 'personal_index', methods: ['GET'])]
    public function index(): Response
    {
        $rutaListaPersonal = $this->generateUrl('personal_lista');

        return $this->render('personal/index.html.twig', [
            'personals' => $this->personalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'personal_new', methods: ['GET', 'POST'])]
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
        ]);
    }

    #[Route('/{slug}', name: 'personal_show', methods: ['GET'])]
    public function show(string $slug): Response
    {
        $personal = $this->personalRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        return $this->render('personal/show.html.twig', [
            'personal' => $personal,
        ]);
    }

    #[Route('/lista', name: 'personal_lista', methods: ['POST'])]
    public function lista(): JsonResponse
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

    #[Route('/{slug}/editar', name: 'personal_edit', methods: ['GET'])]
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


    #[Route('/{id}/actualizar', name: 'personal_update', methods: ['POST'])]
    public function update(Request               $request, int $id, PersonalRepository $personalRepository, EntityManagerInterface $entityManager, SexoRepository $sexoRepository,
                           AfpRepository $afpRepository, EpsRepository $epsRepository, AfcRepository $afcRepository,
                           TipoCuentaRepository  $tipoCuentaRepository, TallaUniformeRepository $tallaUniformeRepository, TallaBotasRepository $tallaBotasRepository,
                           CargoRepository       $cargoRepository, TallaGuantesRepository $tallaGuantesRepository, CursoEspecializadoRepository $cursoEspecializadoRepository,
                           TallaCamisaRepository $tallaCamisaRepository, TallaPantalonRepository $tallaPantalonRepository, TallaCalzadoRepository $tallaCalzadoRepository): Response
    {
        if ($id == 0) {
            $personal = new Personal();
        } else {
            $personal = $personalRepository->find($id);
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

    #[Route('/{id}/borrar', name: 'personal_delete', methods: ['POST'])]
    public function delete(Request $request, Personal $personal, PersonalRepository $personalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $personal->getId(), $request->request->get('_token'))) {
            $personalRepository->remove($personal, true);
        }

        return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{idContrato}/lista', name: 'personal_contrato_lista', methods: ['POST'])]
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
}
