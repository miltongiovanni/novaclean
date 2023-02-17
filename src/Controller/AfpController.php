<?php

namespace App\Controller;

use App\Entity\Afp;
use App\Form\AfpType;
use App\Repository\AfpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/afp')]
class AfpController extends AbstractController
{
    #[Route('/', name: 'app_afp_index', methods: ['GET'])]
    public function index(AfpRepository $afpRepository): Response
    {
        return $this->render('afp/index.html.twig', [
            'afps' => $afpRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_afp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AfpRepository $afpRepository): Response
    {
        $afp = new Afp();
        $form = $this->createForm(AfpType::class, $afp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $afpRepository->save($afp, true);

            return $this->redirectToRoute('app_afp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('afp/new.html.twig', [
            'afp' => $afp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_afp_show', methods: ['GET'])]
    public function show(Afp $afp): Response
    {
        return $this->render('afp/show.html.twig', [
            'afp' => $afp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_afp_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Afp $afp, AfpRepository $afpRepository): Response
    {
        $form = $this->createForm(AfpType::class, $afp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $afpRepository->save($afp, true);

            return $this->redirectToRoute('app_afp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('afp/edit.html.twig', [
            'afp' => $afp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_afp_delete', methods: ['POST'])]
    public function delete(Request $request, Afp $afp, AfpRepository $afpRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$afp->getId(), $request->request->get('_token'))) {
            $afpRepository->remove($afp, true);
        }

        return $this->redirectToRoute('app_afp_index', [], Response::HTTP_SEE_OTHER);
    }
}
