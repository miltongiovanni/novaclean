<?php

namespace App\Controller;

use App\Entity\Eps;
use App\Form\EpsType;
use App\Repository\EpsRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eps')]
class EpsController extends AbstractController
{
    #[Route('/', name: 'eps_index', methods: ['GET'])]
    public function index(EpsRepository $epsRepository): Response
    {
        return $this->render('eps/index.html.twig', [
            'epses' => $epsRepository->findAll(),
        ]);
    }

    #[Route('/nueva', name: 'eps_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EpsRepository $epsRepository): Response
    {
        return $this->render('eps/new.html.twig', [
            'action' => 'insert',
        ]);
    }

    #[Route('/{id}', name: 'eps_show', methods: ['GET'])]
    public function show(Eps $eps): Response
    {
        return $this->render('eps/show.html.twig', [
            'eps' => $eps,
        ]);
    }

    #[Route('/{id}/editar', name: 'eps_edit', methods: ['GET'])]
    public function edit(Request $request, Eps $eps, EpsRepository $epsRepository): Response
    {
        return $this->render('eps/edit.html.twig', [
            'eps' => $eps,
            'action' => 'update',
        ]);
    }

    #[Route('/{id}/actualizar', name: 'eps_update', methods: ['POST'])]
    public function update(Request $request, int $id, EpsRepository $epsRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id == 0) {
            $eps = new Eps();
        } else {
            $eps = $epsRepository->find($id);
        }
        $action = $request->request->get('action');
        $eps->setNombre($request->request->get('nombre'));
        $eps->setContacto($request->request->get('contacto'));
        $eps->setTelefono($request->request->get('telefono'));
        $eps->setExtension(intval($request->request->get('extension')));
        $eps->setCelular($request->request->get('celular'));
        $eps->setUser($this->getUser());
        if ($action == 'insert') {
            $eps->setFechaCreacion(Carbon::today());
        }
        $eps->setFechaActualizacion(Carbon::today());
        $entityManager->persist($eps);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'EPS creada correctamente');
        } else {
            $this->addFlash('success', 'EPS actualizada correctamente');
        }
        return $this->redirectToRoute('eps_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'eps_delete', methods: ['POST'])]
    public function delete(Request $request, Eps $ep, EpsRepository $epsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ep->getId(), $request->request->get('_token'))) {
            $epsRepository->remove($ep, true);
        }

        return $this->redirectToRoute('eps_index', [], Response::HTTP_SEE_OTHER);
    }
}
