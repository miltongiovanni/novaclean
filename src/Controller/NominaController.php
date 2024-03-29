<?php

namespace App\Controller;

use App\Entity\ParametroNomina;
use App\Entity\TipoNovedadNomina;
use App\Repository\ParametroNominaRepository;
use App\Repository\TipoNovedadNominaRepository;
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

    #[Route('/parametro/nuevo', name: 'parametro_new', methods: ['GET', 'POST'])]
    public function parametro_new(Request $request): Response
    {
        return $this->render('nomina/new_parametro_nomina.html.twig', [
            'action' => 'insert',
        ]);
    }


    #[Route('/parametro/{id}/editar', name: 'parametro_edit', methods: ['GET'])]
    public function parametro_edit(Request $request, ParametroNomina $parametroNomina, ParametroNominaRepository $parametroNominaRepository): Response
    {
        return $this->render('nomina/edit_parametro_nomina.html.twig', [
            'parametroNomina' => $parametroNomina,
            'action' => 'update',
        ]);
    }

    #[Route('/parametro/{id}/actualizar', name: 'parametro_nomina_update', methods: ['POST'])]
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

    #[Route('/tipos-novedad', name: 'tipos_novedad_nomina')]
    public function tipos_novedades(TipoNovedadNominaRepository $tipoNovedadNominaRepository): Response
    {
        return $this->render('nomina/tipo_novedades.html.twig', [
            'tipos_novedades' => $tipoNovedadNominaRepository->findAll(),
        ]);
    }

    #[Route('/tipo-novedad/nuevo', name: 'tipo_novedad_nomina_new', methods: ['GET', 'POST'])]
    public function tipo_novedad_new(Request $request): Response
    {
        return $this->render('nomina/new_tipo_novedad_nomina.html.twig', [
            'action' => 'insert',
        ]);
    }


    #[Route('/tipo-novedad/{id}/editar', name: 'tipo_novedad_nomina_edit', methods: ['GET'])]
    public function tipo_novedad_edit(Request $request, TipoNovedadNomina $tipoNovedadNomina, TipoNovedadNominaRepository $tipoNovedadNominaRepository): Response
    {
        return $this->render('nomina/edit_tipo_novedad_nomina.html.twig', [
            'tipoNovedadNomina' => $tipoNovedadNomina,
            'action' => 'update',
        ]);
    }

    #[Route('/tipo-novedad/{id}/actualizar', name: 'tipo_novedad_nomina_update', methods: ['POST'])]
    public function tipo_novedad_update(Request $request, int $id, TipoNovedadNominaRepository $tipoNovedadNominaRepository, EntityManagerInterface $entityManager): Response
    {
        if ($id == 0) {
            $tipo_novedad_nomina = new TipoNovedadNomina();
            $tipo_novedad_nomina->setFechaCreacion(Carbon::today());
        } else {
            $tipo_novedad_nomina = $tipoNovedadNominaRepository->find($id);
        }
        $tipo_novedad_nomina->setUser($this->getUser());
        $tipo_novedad_nomina->setFechaActualizacion(Carbon::today());
        $tipo_novedad_nomina->setDescripcion(trim($request->request->get('descripcion')));
        $action = $request->request->get('action');
        $entityManager->persist($tipo_novedad_nomina);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        if ($action == 'insert') {
            $this->addFlash('success', 'Tipo novedad de nómina creado correctamente');
        } else {
            $this->addFlash('success', 'Tipo novedad de nómina actualizado correctamente');
        }
        return $this->redirectToRoute('tipos_novedad_nomina', [], Response::HTTP_SEE_OTHER);
    }
}
