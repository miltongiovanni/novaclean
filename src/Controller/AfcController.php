<?php

namespace App\Controller;

use App\Entity\Afc;
use App\Form\AfcType;
use App\Repository\AfcRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/afc')]
class AfcController extends AbstractController
{
    #[Route('/', name: 'afc_index', methods: ['GET'])]
    public function index(AfcRepository $afcRepository): Response
    {
        return $this->render('afc/index.html.twig', [
            'afcs' => $afcRepository->findAll(),
        ]);
    }

    #[Route('/nueva', name: 'afc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AfcRepository $afcRepository): Response
    {
        return $this->render('afc/new.html.twig', [
            'action' => 'insert',
        ]);
    }

    #[Route('/{id}', name: 'afc_show', methods: ['GET'])]
    public function show(Afc $afc): Response
    {
        return $this->render('afc/show.html.twig', [
            'afc' => $afc,
        ]);
    }

    #[Route('/{id}/editar', name: 'afc_edit', methods: ['GET'])]
    public function edit(Request $request, Afc $afc, AfcRepository $afcRepository): Response
    {
        return $this->render('afc/edit.html.twig', [
            'afc' => $afc,
            'action' => 'update',
        ]);
    }

    #[Route('/{id}/actualizar', name: 'afc_update', methods: ['POST'])]
    public function update(Request $request, int $id, AfcRepository $afcRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id == 0) {
            $afc = new Afc();
        } else {
            $afc = $afcRepository->find($id);
        }
        $action = $request->request->get('action');
        $afc->setNombre($request->request->get('nombre'));
        $afc->setContacto($request->request->get('contacto'));
        $afc->setTelefono($request->request->get('telefono'));
        $afc->setExtension(intval($request->request->get('extension')));
        $afc->setCelular($request->request->get('celular'));
        $afc->setUser($this->getUser());
        if ($action == 'insert') {
            $afc->setFechaCreacion(Carbon::now());
        }
        $afc->setFechaActualizacion(Carbon::now());
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

    #[Route('/{id}', name: 'afc_delete', methods: ['POST'])]
    public function delete(Request $request, Afc $afc, AfcRepository $afcRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $afc->getId(), $request->request->get('_token'))) {
            $afcRepository->remove($afc, true);
        }

        return $this->redirectToRoute('afc_index', [], Response::HTTP_SEE_OTHER);
    }
}
