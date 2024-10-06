<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/cliente')]
class ClienteController extends AbstractController
{
    #[Route('/', name: 'cliente_index', methods: ['GET'])]
    public function index(ClienteRepository $clienteRepository): Response
    {
        return $this->render('cliente/index.html.twig', [
            'clientes' => $clienteRepository->findAll(),
        ]);
    }

    #[Route('/nuevo', name: 'cliente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClienteRepository $clienteRepository): Response
    {
        $slug = Uuid::v6();
        return $this->render('cliente/new.html.twig', [
            'action' => 'insert',
            'slug' => $slug,
        ]);
    }
    #[Route('/lista', name: 'cliente_lista', methods: ['POST'])]
    public function lista(ClienteRepository $clienteRepository): JsonResponse
    {
        $clientes = $clienteRepository->findAll();
        $clientesToArray = [];
        foreach ($clientes as $key => $cliente) {
            $clientesToArray[$key] = $cliente->toArray();
            $clientesToArray[$key]['estado_show'] = $clientesToArray[$key]['estado'] == true ? '<i class="bi bi-check-circle-fill activo"></i>' : '<i class="bi bi-x-circle-fill inactivo"></i>';
            //$clientesToArray[$key]['actions'] = $this->renderView('cliente/_cliente.buttons.html.twig', ['cliente' => $clientesToArray[$key]]);
        }

        //To array
//        $personalsToArray = array_map(function ($personal) {
//            /** @var Personal $personal */
//            $arr = $personal->toArray();
//            return $arr;
//        }, $personals);
        $return = [
            'draw' => 0,
            'recordsTotal' => count($clientesToArray),
            'recordsFiltered' => count($clientesToArray),
            'data' => $clientesToArray
        ];

        return $this->json($return);
    }
    #[Route('/{slug}/editar', name: 'cliente_edit', methods: ['GET'])]
    public function edit(Request $request, string $slug, ClienteRepository $clienteRepository): Response
    {
        $cliente = $clienteRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        //dd($cliente->getSlug()->toRfc4122());

        return $this->render('cliente/edit.html.twig', [
            'cliente' => $cliente->toArray(),
            'action' => 'update',
        ]);
    }

    #[Route('/{slug}/actualizar', name: 'cliente_update', methods: ['POST'])]
    public function update(Request $request, string $slug, EntityManagerInterface $entityManager, ClienteRepository $clienteRepository): Response
    {
        $user = $this->getUser();
        $action = $request->request->get('action');
        $cliente = $clienteRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        if (!$cliente){
            $cliente = new Cliente();
            $cliente->setSlug(Uuid::fromString($slug));
        }
        $cliente->setEstado(trim($request->request->get('estado', false)));
        $cliente->setNit(trim($request->request->get('nit', '')));
        $cliente->setNombre(trim($request->request->get('nombre', '')));
        $cliente->setDireccion(trim($request->request->get('direccion', '')));
        $cliente->setTelefono(trim($request->request->get('telefono', '')));
        $cliente->setTelefono2(trim($request->request->get('telefono2', '')));
        $cliente->setContacto(trim($request->request->get('contacto', '')));
        $cliente->setCelular(trim($request->request->get('celular', '')));
        $cliente->setCorreoElectronico(trim($request->request->get('correo_electronico', '')));
        $cliente->setObservaciones(trim($request->request->get('observaciones', '')));
        $cliente->setFActualizacion(Carbon::now());
        $cliente->setUser($user);
        $entityManager->persist($cliente);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        if ($action == 'insert') {
            $this->addFlash('success', 'Cliente creado correctamente');
        } else {
            $this->addFlash('success', 'Cliente actualizado correctamente');
        }

        //$this->addFlash('error', ' Error al actualizar el Cliente');
        return $this->redirectToRoute('cliente_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{slug}/activar', name: 'cliente_activate', methods: ['GET'])]
    public function activate(Request $request, string $slug, EntityManagerInterface $entityManager, ClienteRepository $clienteRepository): Response
    {
        $cliente = $clienteRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $cliente->setEstado(true);
        $entityManager->persist($cliente);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Cliente activado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Cliente');
        return $this->redirectToRoute('cliente_index', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/{slug}/desactivar', name: 'cliente_deactivate', methods: ['GET'])]
    public function deactivate(Request $request, string $slug, EntityManagerInterface $entityManager, ClienteRepository $clienteRepository): Response
    {
        $cliente = $clienteRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        $cliente->setEstado(false);
        $entityManager->persist($cliente);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Cliente desactivado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Cliente');
        return $this->redirectToRoute('cliente_index', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{slug}', name: 'cliente_show', methods: ['GET'])]
    public function show(string $slug, ClienteRepository $clienteRepository): Response
    {
        $cliente = $clienteRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        return $this->render('cliente/show.html.twig', [
            'cliente' => $cliente,
        ]);
    }

    #[Route('/{slug}/borrar', name: 'cliente_delete', methods: ['POST'])]
    public function delete(Request $request, string $slug, ClienteRepository $clienteRepository): Response
    {
        $cliente = $clienteRepository->findOneBy(['slug' => Uuid::fromString($slug) ]);
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $clienteRepository->remove($cliente, true);
        }
        return $this->redirectToRoute('cliente_index', [], Response::HTTP_SEE_OTHER);
    }
}
