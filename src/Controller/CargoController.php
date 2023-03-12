<?php

namespace App\Controller;

use App\Entity\Cargo;
use App\Repository\CargoRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cargo')]
class CargoController extends AbstractController
{
    #[Route('/', name: 'cargo_index', methods: ['GET'])]
    public function index(CargoRepository $cargoRepository): Response
    {
        return $this->render('cargo/index.html.twig', [
            'cargos' => $cargoRepository->findAll(),
        ]);
    }

    #[Route('/nuevo', name: 'cargo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CargoRepository $cargoRepository): Response
    {
        return $this->render('cargo/new.html.twig', [
            'action' => 'insert',
        ]);
    }

    #[Route('/{id}', name: 'cargo_show', methods: ['GET'])]
    public function show(Cargo $cargo): Response
    {
        return $this->render('cargo/show.html.twig', [
            'cargo' => $cargo,
        ]);
    }

    #[Route('/{id}/editar', name: 'cargo_edit', methods: ['GET'])]
    public function edit(Request $request, Cargo $cargo, CargoRepository $cargoRepository): Response
    {

        return $this->render('cargo/edit.html.twig', [
            'cargo' => $cargo,
            'action' => 'update',
        ]);
    }


    #[Route('/{id}/actualizar', name: 'cargo_update', methods: ['POST'])]
    public function update(Request $request, int $id, CargoRepository $cargoRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id == 0) {
            $cargo = new Cargo();
        } else {
            $cargo = $cargoRepository->find($id);
        }
        $action = $request->request->get('action');
        $cargo->setDescripcion(trim($request->request->get('descripcion')));
        $entityManager->persist($cargo);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Cargo creado correctamente');
        } else {
            $this->addFlash('success', 'Cargo actualizado correctamente');
        }
        return $this->redirectToRoute('cargo_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}', name: 'cargo_delete', methods: ['POST'])]
    public function delete(Request $request, Cargo $cargo, CargoRepository $cargoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cargo->getId(), $request->request->get('_token'))) {
            $cargoRepository->remove($cargo, true);
        }

        return $this->redirectToRoute('cargo_index', [], Response::HTTP_SEE_OTHER);
    }
}
