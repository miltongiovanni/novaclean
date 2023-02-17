<?php

namespace App\Controller;

use App\Entity\Eps;
use App\Form\EpsType;
use App\Repository\EpsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eps')]
class EpsController extends AbstractController
{
    #[Route('/', name: 'app_eps_index', methods: ['GET'])]
    public function index(EpsRepository $epsRepository): Response
    {
        return $this->render('eps/index.html.twig', [
            'eps' => $epsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_eps_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EpsRepository $epsRepository): Response
    {
        $ep = new Eps();
        $form = $this->createForm(EpsType::class, $ep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $epsRepository->save($ep, true);

            return $this->redirectToRoute('app_eps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eps/new.html.twig', [
            'ep' => $ep,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eps_show', methods: ['GET'])]
    public function show(Eps $ep): Response
    {
        return $this->render('eps/show.html.twig', [
            'ep' => $ep,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eps_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eps $ep, EpsRepository $epsRepository): Response
    {
        $form = $this->createForm(EpsType::class, $ep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $epsRepository->save($ep, true);

            return $this->redirectToRoute('app_eps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eps/edit.html.twig', [
            'ep' => $ep,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eps_delete', methods: ['POST'])]
    public function delete(Request $request, Eps $ep, EpsRepository $epsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ep->getId(), $request->request->get('_token'))) {
            $epsRepository->remove($ep, true);
        }

        return $this->redirectToRoute('app_eps_index', [], Response::HTTP_SEE_OTHER);
    }
}
