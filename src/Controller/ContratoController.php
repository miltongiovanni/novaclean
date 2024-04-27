<?php

namespace App\Controller;

use App\Entity\Contrato;
use App\Entity\ContratoPersonal;
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
        $contratos = $this->contratoRepository->getAllContratos();
//        $now = new Carbon();
//        $contratosToArray = [];
//        foreach ($contratos as $key => $contrato) {
//            $contratosToArray[$key] = $contrato->toArray();
//            $end_contrato_date = Carbon::createFromFormat('Y-m-d', $contratosToArray[$key]['f_fin']);
//            if ($end_contrato_date->greaterThan($now)) {
//                $contratosToArray[$key]['estado'] = '<i class="bi bi-check-circle-fill activo"></i>';
//            } else {
//                $contratosToArray[$key]['estado'] = '<i class="bi bi-x-circle-fill inactivo"></i>';
//            }
//            $contratosToArray[$key]['actions'] = $this->renderView('contrato/_contrato.buttons.html.twig', ['contrato' => $contratosToArray[$key]]);
//        }

        //To array
//        $personalsToArray = array_map(function ($personal) {
//            /** @var Personal $personal */
//            $arr = $personal->toArray();
//            return $arr;
//        }, $personals);
        $return = [
            'draw' => 0,
            'recordsTotal' => count($contratos),
            'recordsFiltered' => count($contratos),
            'data' => $contratos
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
    #[Route('/{slug}/renovar', name: 'contrato_renovar', methods: ['GET'])]
    public function renew(Request $request, string $slug, ContratoRepository $contratoRepository, ClienteRepository $clienteRepository, PersonalRepository $personalRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $supervisores = $personalRepository->findBy(['cargo' => self::SUPERVISOR_ID], ['nombre' => 'asc']);
        $clientes = $clienteRepository->findBy(['estado' => true], ['nombre' => 'asc']);
        return $this->render('contrato/edit.html.twig', [
            'contrato' => $contrato->toArray(),
            'supervisores' => $supervisores,
            'clientes' => $clientes,
            'action' => 'renovar',
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
        $contrato_id = $request->request->get('contrato_id');
        if ($contrato_id){
            $contrato->setNContrato($contrato_id);
        }
        $cliente_id = $request->request->get('cliente_id');
        if ($cliente_id){
            $cliente = $clienteRepository->find($cliente_id);
            $contrato->setCliente($cliente);
        }
        $supervisor_id = $request->request->get('supervisor_id');
        if ($supervisor_id){
            $supervisor = $personalRepository->find($supervisor_id);
            $contrato->setPersonal($supervisor);
        }
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
        if ($tiene_poliza_salario){
            $contrato->setPolizaSalario($tiene_poliza_salario);
        }
        $tiene_poliza_cumplimiento = $request->request->get('tiene_poliza_cumplimiento', false);
        if ($tiene_poliza_cumplimiento){
            $contrato->setPolizaCumplimiento($tiene_poliza_cumplimiento);
        }
        $no_poliza = $request->request->get('no_poliza', false);
        if ($no_poliza){
            $contrato->setNPoliza($no_poliza);
        }
        $aseguradora = $request->request->get('aseguradora', false);
        if ($aseguradora){
            $contrato->setAseguradora($aseguradora);
        }
        $vencimiento_poliza = $request->request->get('vencimiento_poliza');
        if ($vencimiento_poliza != ''){
            $contrato->setVencimientoPoliza(Carbon::createFromFormat('Y-m-d', $vencimiento_poliza));
        }

        $observaciones = $request->request->get('observaciones', false);
        if ($observaciones){
            $contrato->setObservaciones($observaciones);
        }
        $entityManager->persist($contrato);
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Contrato creado correctamente');
        } elseif ($action == 'renovar') {
            $this->addFlash('success', 'Contrato renovado correctamente');
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

    #[Route('/{slugcontrato}/personal/{slugpersonal}/editar', name: 'contrato_personal_edit', methods: ['GET'])]
    public function contrato_personal_edit(Request $request, string $slugcontrato, string $slugpersonal, ContratoRepository $contratoRepository, ClienteRepository $clienteRepository, PersonalRepository $personalRepository, TipoNominaRepository $tipoNominaRepository, ContratoPersonalRepository $contratoPersonalRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slugcontrato) ]);
        $personal = $personalRepository->findOneBy(['slug' => Uuid::fromString($slugpersonal) ]);
        $personal_contrato = $contratoPersonalRepository->findOneBy(['personal' => $personal, 'contrato' => $contrato]);
        $tiposNomina = $tipoNominaRepository->findAll();
        return $this->render('contrato/personal.edit.html.twig', [
            'contrato' => $contrato->toArray(),
            'personal_contrato' => $personal_contrato->toArray(),
            'tiposNomina' => $tiposNomina,
            'action' => 'update',
        ]);
    }
    #[Route('/{slugcontrato}/personal/{slugpersonal}/actualizar', name: 'contrato_personal_update', methods: ['POST'])]
    public function contrato_personal_update(string $slugcontrato, string $slugpersonal, Request $request, EntityManagerInterface $entityManager, ContratoRepository $contratoRepository, ContratoPersonalRepository $contratoPersonalRepository, PersonalRepository $personalRepository, TipoNominaRepository $tipoNominaRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slugcontrato) ]);
        $personal = $personalRepository->findOneBy(['slug' => Uuid::fromString($slugpersonal) ]);
        $personal_contrato = $contratoPersonalRepository->findOneBy(['personal' => $personal, 'contrato' => $contrato]);
        if (!$personal_contrato){
            $personal_contrato = new ContratoPersonal();
            $personal_contrato->setContrato($contrato);
            $personal_contrato->setPersonal($personal);
        }
        $salario_basico = $request->request->get('salario_basico');
        if ($salario_basico){
            $personal_contrato->setSalarioBasico($salario_basico);
        }
        $bono = $request->request->get('bono');
        if ($bono){
            $personal_contrato->setBono($bono);
        }
        $tipoNomina = $tipoNominaRepository->find($request->request->get('tipo_nomina'));
        $personal_contrato->setTipoNomina($tipoNomina);
        $personal_contrato->setFechaIngreso(Carbon::createFromFormat('Y-m-d', trim($request->request->get('fecha_ingreso'))));
        $action = $request->request->get('action');
        $entityManager->persist($personal_contrato);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Personal agreado al Contrato correctamente');
        } else {
            $this->addFlash('success', 'Personal actualizado al Contrato correctamente');
        }

        return $this->redirectToRoute('contrato_personal', [ 'slug' => $slugcontrato ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{slugcontrato}/personal/{slugpersonal}/retirar', name: 'contrato_personal_retirar', methods: ['POST'])]
    public function contrato_personal_retirar(string $slugcontrato, string $slugpersonal, Request $request, EntityManagerInterface $entityManager, ContratoRepository $contratoRepository, ContratoPersonalRepository $contratoPersonalRepository, PersonalRepository $personalRepository, TipoNominaRepository $tipoNominaRepository): Response
    {
        $contrato = $contratoRepository->findOneBy(['slug' => Uuid::fromString($slugcontrato) ]);
        $personal = $personalRepository->findOneBy(['slug' => Uuid::fromString($slugpersonal) ]);
        $personal_contrato = $contratoPersonalRepository->findOneBy(['personal' => $personal, 'contrato' => $contrato]);
        $fecha_retiro = $request->request->get('fecha_retiro');
        if ($fecha_retiro){
            $personal_contrato->setFechaRetiro(Carbon::createFromFormat('Y-m-d', trim($fecha_retiro)));
        }
        $entityManager->persist($personal_contrato);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        $this->addFlash('success', 'Personal retirado del Contrato correctamente');

        return $this->redirectToRoute('contrato_personal', [ 'slug' => $slugcontrato ], Response::HTTP_SEE_OTHER);
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
