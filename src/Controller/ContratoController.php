<?php

namespace App\Controller;

use App\Entity\Contrato;
use App\Form\ContratoType;
use App\Repository\ContratoRepository;
use App\Repository\PersonalRepository;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index(ContratoRepository $contratoRepository): Response
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


    #[Route('/new', name: 'contrato_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContratoRepository $contratoRepository): Response
    {
        $contrato = new Contrato();
        $form = $this->createForm(ContratoType::class, $contrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contratoRepository->save($contrato, true);

            return $this->redirectToRoute('contrato_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrato/new.html.twig', [
            'contrato' => $contrato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contrato_show', methods: ['GET'])]
    public function show(Contrato $contrato): Response
    {
        return $this->render('contrato/show.html.twig', [
            'contrato' => $contrato,
        ]);
    }

    #[Route('/{id}/editar', name: 'contrato_edit', methods: ['GET'])]
    public function edit(Request $request, Contrato $contrato, ContratoRepository $contratoRepository, PersonalRepository $personalRepository): Response
    {
        $supervisores = $personalRepository->findBy(['cargo'=>self::SUPERVISOR_ID], ['nombre'=>'asc']);

        return $this->render('contrato/edit.html.twig', [
            'contrato' => $contrato,
            'supervisores' => $supervisores,
            'action' => 'update',
        ]);
    }

    #[Route('/{id}', name: 'contrato_delete', methods: ['POST'])]
    public function delete(Request $request, Contrato $contrato, ContratoRepository $contratoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrato->getId(), $request->request->get('_token'))) {
            $contratoRepository->remove($contrato, true);
        }

        return $this->redirectToRoute('contrato_index', [], Response::HTTP_SEE_OTHER);
    }
}
