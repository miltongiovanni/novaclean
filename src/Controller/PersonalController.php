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
    public function new(Request $request, PersonalRepository $personalRepository): Response
    {
        $personal = new Personal();
        $form = $this->createForm(PersonalType::class, $personal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalRepository->save($personal, true);

            return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personal/new.html.twig', [
            'personal' => $personal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'personal_show', methods: ['GET'])]
    public function show(Personal $personal): Response
    {
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
            if ($personalsToArray[$key]['activo'] == true) {
                $personalsToArray[$key]['estado'] = '<i class="bi bi-check-circle-fill activo"></i>';
            } else {
                $personalsToArray[$key]['estado'] = '<i class="bi bi-x-circle-fill inactivo"></i>';
            }
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

    #[Route('/{id}/editar', name: 'personal_edit', methods: ['GET'])]
    public function edit(Request $request, Personal $personal, SexoRepository $sexoRepository, TipoNominaRepository $tipoNominaRepository, AfpRepository $afpRepository,
                         EpsRepository $epsRepository, AfcRepository $afcRepository, TipoCuentaRepository $tipoCuentaRepository, TallaUniformeRepository $tallaUniformeRepository,
                         TallaBotasRepository $tallaBotasRepository, CargoRepository $cargoRepository, TallaGuantesRepository $tallaGuantesRepository,
                         CursoEspecializadoRepository $cursoEspecializadoRepository, TallaCamisaRepository $tallaCamisaRepository, TallaPantalonRepository $tallaPantalonRepository,
                         TallaCalzadoRepository $tallaCalzadoRepository,   ): Response
    {
        $sexos = $sexoRepository->findAll();
        $tiposNomina = $tipoNominaRepository->findAll();
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
            'tiposNomina' => $tiposNomina,
            'tallasCamisa' => $tallasCamisa,
            'tallasPantalon' => $tallasPantalon,
            'tallasCalzado' => $tallasCalzado,
        ]);
    }


    #[Route('/{id}/actualizar', name: 'personal_update', methods: ['POST'])]
    public function update(Request $request, int $id, PersonalRepository $personalRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id == 0) {
            $afc = new Personal();
        } else {
            $afc = $personalRepository->find($id);
        }
        dd($request->request);
        $action = $request->request->get('action');
        $afc->setNombre(trim($request->request->get('nombre')));
        $afc->setContacto(trim($request->request->get('contacto')));
        $afc->setTelefono(trim($request->request->get('telefono')));
        $afc->setExtension(intval($request->request->get('extension')));
        $afc->setCelular(trim($request->request->get('celular')));
        $afc->setUser($this->getUser());
        if ($action == 'insert') {
            $afc->setFechaCreacion(Carbon::today());
        }
        $afc->setFechaActualizacion(Carbon::today());
        $entityManager->persist($afc);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'AFC creada correctamente');
        } else {
            $this->addFlash('success', 'AFC actualizada correctamente');
        }
        return $this->redirectToRoute('afc_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'personal_delete', methods: ['POST'])]
    public function delete(Request $request, Personal $personal, PersonalRepository $personalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $personal->getId(), $request->request->get('_token'))) {
            $personalRepository->remove($personal, true);
        }

        return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
    }
}
