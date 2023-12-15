<?php

namespace App\Controller;

use App\Entity\Contrato;
use App\Form\ContratoType;
use App\Repository\ClienteRepository;
use App\Repository\ContratoPersonalRepository;
use App\Repository\ContratoRepository;
use App\Repository\PersonalRepository;
use App\Repository\TipoNominaRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/contrato')]
class ContratoController extends AbstractController
{
    private ContratoRepository $contratoRepository;
    const SUPERVISOR_ID = 14;

    public function __construct(ContratoRepository $contratoRepository)
    {
        $this->contratoRepository = $contratoRepository;
    }

    #[Route('/', name: 'contrato_index', methods: ['GET'])]
    public function index(ContratoRepository $contratoRepository, EntityManagerInterface $entityManager): Response
    {
        return $this->render('contrato/index.html.twig', [
            'contratos' => $contratoRepository->findAll(),
        ]);
    }

    #[Route('/lista', name: 'contrato_lista', methods: ['POST'])]
    public function lista(): JsonResponse
    {
        $contratos = $this->contratoRepository->findAll();
        $now = new Carbon();
        $contratosToArray = [];
        foreach ($contratos as $key => $contrato) {
            $contratosToArray[$key] = $contrato->toArray();
            $end_contrato_date = Carbon::createFromFormat('d/m/Y', $contratosToArray[$key]['f_fin']);
            if ($end_contrato_date->greaterThan($now)) {
                $contratosToArray[$key]['estado'] = '<i class="bi bi-check-circle-fill activo"></i>';
            } else {
                $contratosToArray[$key]['estado'] = '<i class="bi bi-x-circle-fill inactivo"></i>';
            }
            $contratosToArray[$key]['actions'] = $this->renderView('contrato/_contrato.buttons.html.twig', ['contrato' => $contratosToArray[$key]]);
        }

        //To array
//        $personalsToArray = array_map(function ($personal) {
//            /** @var Personal $personal */
//            $arr = $personal->toArray();
//            return $arr;
//        }, $personals);
        $return = [
            'draw' => 0,
            'recordsTotal' => count($contratosToArray),
            'recordsFiltered' => count($contratosToArray),
            'data' => $contratosToArray
        ];

        return $this->json($return);
    }


    #[Route('/new', name: 'contrato_new', methods: ['GET'])]
    public function new(Request $request, PersonalRepository $personalRepository, ClienteRepository $clienteRepository): Response
    {
        $supervisores = $personalRepository->findBy(['cargo' => self::SUPERVISOR_ID], ['nombre' => 'asc']);
        $clientes = $clienteRepository->findBy(['estado' => true], ['nombre' => 'asc']);
        $slug = Uuid::v7();
        return $this->render('contrato/new.html.twig', [
            'supervisores' => $supervisores,
            'clientes' => $clientes,
            'slug' => $slug,
            'action' => 'insert',
        ]);
    }

    #[Route('/{slug}/personal', name: 'contrato_personal', methods: ['GET'])]
    public function contrato_personal(string $slug, ContratoRepository $contratoRepository, TipoNominaRepository $tipoNominaRepository, PersonalRepository $personalRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $tiposNomina = $tipoNominaRepository->findAll();
        return $this->render('contrato/personal.html.twig', [
            'contrato' => $contrato->toArray(),
            'personal' => $personalRepository->findAll(),
            'tiposNomina' => $tiposNomina,
        ]);
    }
    #[Route('/{slug}/personal/lista', name: 'lista_contrato_personal', methods: ['POST'])]
    public function lista_contrato_personal(string $slug, ContratoRepository $contratoRepository, ContratoPersonalRepository $contratoPersonalRepository): JsonResponse
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $personalContrato = $contratoPersonalRepository->findBy(['contrato' => $contrato]);
        $personalContratoToArray = [];
        foreach ($personalContrato as $key => &$personal) {
            $personalContratoToArray[$key] = $personal->toArray();
            $personalContratoToArray[$key]['actions'] = $this->renderView('contrato/_contrato_personal.buttons.html.twig', ['personal_contrato' => $personalContratoToArray[$key]]);
        }
        $return = [
            'draw' => 0,
            'recordsTotal' => count($personalContratoToArray),
            'recordsFiltered' => count($personalContratoToArray),
            'data' => $personalContratoToArray
        ];

        return $this->json($return);
    }

    #[Route('/{slug}/editar', name: 'contrato_edit', methods: ['GET'])]
    public function edit(Request $request, string $slug, ContratoRepository $contratoRepository, ClienteRepository $clienteRepository, PersonalRepository $personalRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $supervisores = $personalRepository->findBy(['cargo' => self::SUPERVISOR_ID], ['nombre' => 'asc']);
        $clientes = $clienteRepository->findBy(['estado' => true], ['nombre' => 'asc']);
        return $this->render('contrato/edit.html.twig', [
            'contrato' => $contrato->toArray(),
            'supervisores' => $supervisores,
            'clientes' => $clientes,
            'action' => 'update',
        ]);
    }

    #[Route('/{slug}/actualizar', name: 'contrato_update', methods: ['POST'])]
    public function update(string $slug, Request $request, EntityManagerInterface $entityManager, ContratoRepository $contratoRepository, ClienteRepository $clienteRepository, PersonalRepository $personalRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        if (!$contrato){
            $contrato = new Contrato();
            $contrato->setSlug(Uuid::fromString($slug));
        }
        $action = $request->request->get('action');
        $contrato->setNContrato($request->request->get('contrato_id'));
        $cliente = $clienteRepository->find($request->request->get('cliente_id'));
        $contrato->setCliente($cliente);
        $supervisor = $personalRepository->find($request->request->get('cliente_id'));
        $contrato->setPersonal($supervisor);
        $contrato->setUser($this->getUser());
        $f_inicio = $request->request->get('f_inicio');
        if ($f_inicio != ''){
            $contrato->setFInicio(Carbon::createFromFormat('Y-m-d', $f_inicio));
        }
        $f_fin = $request->request->get('f_fin');
        if ($f_fin != ''){
            $contrato->setFFin(Carbon::createFromFormat('Y-m-d', $f_fin));
        }
        $tiene_poliza_salario = $request->request->get('tiene_poliza_salario', 0);
        $contrato->setPolizaSalario($tiene_poliza_salario);
        $tiene_poliza_cumplimiento = $request->request->get('tiene_poliza_cumplimiento', 0);
        $contrato->setPolizaCumplimiento($tiene_poliza_cumplimiento);

        $entityManager->persist($contrato);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Contrato creado correctamente');
        } else {
            $this->addFlash('success', 'Contrato actualizado correctamente');
        }
        return $this->redirectToRoute('contrato_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{slug}/personal/agregar', name: 'contrato_personal_new', methods: ['GET'])]
    public function contrato_personal_new(string $slug, Request $request, TipoNominaRepository $tipoNominaRepository, ContratoRepository $contratoRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $tiposNomina = $tipoNominaRepository->findAll();
        return $this->render('contrato/personal.new.html.twig', [
            'contrato' => $contrato->toArray(),
            'tiposNomina' => $tiposNomina,
            'slug' => $slug,
            'action' => 'insert',
        ]);
    }

    #[Route('/{slug}/personal/editar', name: 'contrato_personal_edit', methods: ['GET'])]
    public function contrato_personal_edit(Request $request, string $slug, ContratoRepository $contratoRepository, ClienteRepository $clienteRepository, PersonalRepository $personalRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $supervisores = $personalRepository->findBy(['cargo' => self::SUPERVISOR_ID], ['nombre' => 'asc']);
        $clientes = $clienteRepository->findBy(['estado' => true], ['nombre' => 'asc']);
        return $this->render('contrato/personal.edit.html.twig', [
            'contrato' => $contrato->toArray(),
            'supervisores' => $supervisores,
            'clientes' => $clientes,
            'action' => 'update',
        ]);
    }
    #[Route('/{slug}/personal/actualizar', name: 'contrato_personal_update', methods: ['POST'])]
    public function contrato_personal_update(string $slug, Request $request, EntityManagerInterface $entityManager, ContratoRepository $contratoRepository, ClienteRepository $clienteRepository, PersonalRepository $personalRepository): JsonResponse
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        dd($contrato, $request->request->all() );
        if (!$contrato){
            $contrato = new Contrato();
            $contrato->setSlug(Uuid::fromString($slug));
        }
        $action = $request->request->get('action');
        $contrato->setNContrato($request->request->get('contrato_id'));
        $cliente = $clienteRepository->find($request->request->get('cliente_id'));
        $contrato->setCliente($cliente);
        $supervisor = $personalRepository->find($request->request->get('cliente_id'));
        $contrato->setPersonal($supervisor);
        $contrato->setUser($this->getUser());
        $f_inicio = $request->request->get('f_inicio');
        if ($f_inicio != ''){
            $contrato->setFInicio(Carbon::createFromFormat('Y-m-d', $f_inicio));
        }
        $f_fin = $request->request->get('f_fin');
        if ($f_fin != ''){
            $contrato->setFFin(Carbon::createFromFormat('Y-m-d', $f_fin));
        }
        $tiene_poliza_salario = $request->request->get('tiene_poliza_salario', 0);
        $contrato->setPolizaSalario($tiene_poliza_salario);
        $tiene_poliza_cumplimiento = $request->request->get('tiene_poliza_cumplimiento', 0);
        $contrato->setPolizaCumplimiento($tiene_poliza_cumplimiento);

        $entityManager->persist($contrato);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Contrato creado correctamente');
        } else {
            $this->addFlash('success', 'Contrato actualizado correctamente');
        }

        $return = [
            'draw' => 0,
            'recordsTotal' => count($contratosToArray),
            'recordsFiltered' => count($contratosToArray),
            'data' => $contratosToArray
        ];

        return $this->json($return);
    }

    #[Route('/{id}', name: 'contrato_delete', methods: ['POST'])]
    public function delete(Request $request, Contrato $contrato, ContratoRepository $contratoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contrato->getId(), $request->request->get('_token'))) {
            $contratoRepository->remove($contrato, true);
        }

        return $this->redirectToRoute('contrato_index', [], Response::HTTP_SEE_OTHER);
    }
}
