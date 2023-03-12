<?php

namespace App\Controller;

use App\Entity\Afp;
use App\Form\AfpType;
use App\Repository\AfpRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/afp')]
class AfpController extends AbstractController
{
    #[Route('/', name: 'afp_index', methods: ['GET'])]
    public function index(AfpRepository $afpRepository): Response
    {
        return $this->render('afp/index.html.twig', [
            'afps' => $afpRepository->findAll(),
        ]);
    }

    #[Route('/nueva', name: 'afp_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AfpRepository $afpRepository): Response
    {
        return $this->render('afp/new.html.twig', [
            'action' => 'insert',
        ]);
    }

    #[Route('/{id}', name: 'afp_show', methods: ['GET'])]
    public function show(Afp $afp): Response
    {
        return $this->render('afp/show.html.twig', [
            'afp' => $afp,
        ]);
    }

    #[Route('/{id}/editar', name: 'afp_edit', methods: ['GET'])]
    public function edit(Request $request, Afp $afp, AfpRepository $afpRepository): Response
    {
        return $this->render('afp/edit.html.twig', [
            'afp' => $afp,
            'action' => 'update',
        ]);
    }


    #[Route('/{id}/actualizar', name: 'afp_update', methods: ['POST'])]
    public function update(Request $request, int $id, AfpRepository $afpRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id == 0) {
            $afp = new Afp();
        } else {
            $afp = $afpRepository->find($id);
        }
        $action = $request->request->get('action');
        $afp->setNombre(trim($request->request->get('nombre')));
        $afp->setContacto(trim($request->request->get('contacto')));
        $afp->setTelefono(trim($request->request->get('telefono')));
        $afp->setExtension(intval($request->request->get('extension')));
        $afp->setCelular(trim($request->request->get('celular')));
        $afp->setUser($this->getUser());
        if ($action == 'insert') {
            $afp->setFechaCreacion(Carbon::today());
        }
        $afp->setFechaActualizacion(Carbon::today());
        $entityManager->persist($afp);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'AFP creada correctamente');
        } else {
            $this->addFlash('success', 'AFP actualizada correctamente');
        }
        return $this->redirectToRoute('afp_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'afp_delete', methods: ['POST'])]
    public function delete(Request $request, Afp $afp, AfpRepository $afpRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$afp->getId(), $request->request->get('_token'))) {
            $afpRepository->remove($afp, true);
        }

        return $this->redirectToRoute('afp_index', [], Response::HTTP_SEE_OTHER);
    }
}
