<?php

namespace App\Controller;

use App\Entity\Contrato;
use App\Form\ContratoType;
use App\Repository\ContratoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contrato')]
class ContratoController extends AbstractController
{
    #[Route('/', name: 'app_contrato_index', methods: ['GET'])]
    public function index(ContratoRepository $contratoRepository): Response
    {
        return $this->render('contrato/index.html.twig', [
            'contratos' => $contratoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contrato_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContratoRepository $contratoRepository): Response
    {
        $contrato = new Contrato();
        $form = $this->createForm(ContratoType::class, $contrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contratoRepository->save($contrato, true);

            return $this->redirectToRoute('app_contrato_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrato/new.html.twig', [
            'contrato' => $contrato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrato_show', methods: ['GET'])]
    public function show(Contrato $contrato): Response
    {
        return $this->render('contrato/show.html.twig', [
            'contrato' => $contrato,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrato_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contrato $contrato, ContratoRepository $contratoRepository): Response
    {
        $form = $this->createForm(ContratoType::class, $contrato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contratoRepository->save($contrato, true);

            return $this->redirectToRoute('app_contrato_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrato/edit.html.twig', [
            'contrato' => $contrato,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrato_delete', methods: ['POST'])]
    public function delete(Request $request, Contrato $contrato, ContratoRepository $contratoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrato->getId(), $request->request->get('_token'))) {
            $contratoRepository->remove($contrato, true);
        }

        return $this->redirectToRoute('app_contrato_index', [], Response::HTTP_SEE_OTHER);
    }
}
