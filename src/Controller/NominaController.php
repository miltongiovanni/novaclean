<?php

namespace App\Controller;

use App\Entity\ParametroNomina;
use App\Repository\ParametroNominaRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nomina')]
class NominaController extends AbstractController
{
    #[Route('/', name: 'app_nomina')]
    public function index(): Response
    {
        return $this->render('nomina/index.html.twig', [
            'controller_name' => 'NominaController',
        ]);
    }

    #[Route('/parametros', name: 'parametros_nomina')]
    public function parametros(ParametroNominaRepository $parametroNominaRepository): Response
    {
        return $this->render('nomina/parametros.html.twig', [
            'parametros' => $parametroNominaRepository->findAll(),
        ]);
    }

    #[Route('/nuevo', name: 'parametro_new', methods: ['GET', 'POST'])]
    public function parametro_new(Request $request): Response
    {
        return $this->render('nomina/new_parametro_nomina.html.twig', [
            'action' => 'insert',
        ]);
    }


    #[Route('/{id}/editar', name: 'parametro_edit', methods: ['GET'])]
    public function parametro_edit(Request $request, ParametroNomina $parametroNomina, ParametroNominaRepository $parametroNominaRepository): Response
    {
        return $this->render('nomina/new_parametro_nomina.html.twig', [
            'parametroNomina' => $parametroNomina,
            'action' => 'update',
        ]);
    }

    #[Route('/{id}/actualizar', name: 'parametro_nomina_update', methods: ['POST'])]
    public function parametro_nomina_update(Request $request, int $id, ParametroNominaRepository $parametroNominaRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id == 0) {
            $parametro_nomina = new ParametroNomina();
        } else {
            $parametro_nomina = $parametroNominaRepository->find($id);
        }
        $parametro_nomina->setParametro(trim($request->request->get('parametro')));
        $parametro_nomina->setValor(trim($request->request->get('valor')));
        $action = $request->request->get('action');
        if ($action == 'insert') {
            $parametro_nomina->setFechaCreacion(Carbon::today());
            $parametro_nomina->setFechaActualizacion(Carbon::today());
        } else {
            $parametro_nomina->setFechaActualizacion(Carbon::today());
        }
        $entityManager->persist($parametro_nomina);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Parámetro de nómina creado correctamente');
        } else {
            $this->addFlash('success', 'Parámetro de nómina actualizado correctamente');
        }
        return $this->redirectToRoute('parametros_nomina', [], Response::HTTP_SEE_OTHER);
    }

}
