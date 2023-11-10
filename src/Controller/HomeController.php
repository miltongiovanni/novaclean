<?php

namespace App\Controller;

use App\Service\Utilidades;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/validar-nit', name: 'validar-nit')]
    public function validarNit(Request $request, Utilidades $utilidades): JsonResponse
    {
        $numero = $request->request->get('numero');
        $nitValid = $utilidades->getNit($numero);

        return $this->json(['nitValid' => $nitValid]);
    }
}
