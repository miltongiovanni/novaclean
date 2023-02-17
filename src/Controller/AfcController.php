<?php

namespace App\Controller;

use App\Entity\Afc;
use App\Form\AfcType;
use App\Repository\AfcRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/afc')]
class AfcController extends AbstractController
{
    #[Route('/', name: 'app_afc_index', methods: ['GET'])]
    public function index(AfcRepository $afcRepository): Response
    {
        return $this->render('afc/index.html.twig', [
            'afcs' => $afcRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_afc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AfcRepository $afcRepository): Response
    {
        $afc = new Afc();
        $form = $this->createForm(AfcType::class, $afc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $afcRepository->save($afc, true);

            return $this->redirectToRoute('app_afc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('afc/new.html.twig', [
            'afc' => $afc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_afc_show', methods: ['GET'])]
    public function show(Afc $afc): Response
    {
        return $this->render('afc/show.html.twig', [
            'afc' => $afc,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_afc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Afc $afc, AfcRepository $afcRepository): Response
    {
        $form = $this->createForm(AfcType::class, $afc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $afcRepository->save($afc, true);

            return $this->redirectToRoute('app_afc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('afc/edit.html.twig', [
            'afc' => $afc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_afc_delete', methods: ['POST'])]
    public function delete(Request $request, Afc $afc, AfcRepository $afcRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$afc->getId(), $request->request->get('_token'))) {
            $afcRepository->remove($afc, true);
        }

        return $this->redirectToRoute('app_afc_index', [], Response::HTTP_SEE_OTHER);
    }
}
