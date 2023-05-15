<?php

namespace App\Controller;

use App\Entity\Personal;
use App\Form\PersonalType;
use App\Repository\PersonalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/personal')]
class PersonalController extends AbstractController
{
    private PersonalRepository $personalRepository;

    public function __construct(PersonalRepository $personalRepository)
    {
        $this->personalRepository = $personalRepository;
    }

    #[Route('/', name: 'personal_index', methods: ['GET'])]
    public function index(): Response
    {
        $rutaListaPersonal = $this->generateUrl('personal_lista');

        return $this->render('personal/index.html.twig', [
            'personals' => $this->personalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'personal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonalRepository $personalRepository): Response
    {
        $personal = new Personal();
        $form = $this->createForm(PersonalType::class, $personal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalRepository->save($personal, true);

            return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personal/new.html.twig', [
            'personal' => $personal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'personal_show', methods: ['GET'])]
    public function show(Personal $personal): Response
    {
        return $this->render('personal/show.html.twig', [
            'personal' => $personal,
        ]);
    }

    #[Route('/lista', name: 'personal_lista', methods: ['POST'])]
    public function lista(): JsonResponse
    {
        $personals = $this->personalRepository->findAll();
        $personalsToArray = [];
        foreach ($personals as $key => $personal) {
            $personalsToArray[$key] = $personal->toArray();
            if ($personalsToArray[$key]['activo'] == true){
                $personalsToArray[$key]['estado'] = '<i class="bi bi-check-circle-fill activo"></i>';
            }else{
                $personalsToArray[$key]['estado'] = '<i class="bi bi-x-circle-fill inactivo"></i>';
            }
            $personalsToArray[$key]['actions'] = $this->renderView('personal/_personal.buttons.html.twig', ['empleado' => $personalsToArray[$key]]);
        }

        //To array
//        $personalsToArray = array_map(function ($personal) {
//            /** @var Personal $personal */
//            $arr = $personal->toArray();
//            return $arr;
//        }, $personals);
        $return = [
            'draw' => 0,
            'recordsTotal' => count($personalsToArray),
            'recordsFiltered' => count($personalsToArray),
            'data' => $personalsToArray
        ];

        return $this->json($return);
    }

    #[Route('/{id}/edit', name: 'personal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Personal $personal, PersonalRepository $personalRepository): Response
    {
        $form = $this->createForm(PersonalType::class, $personal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalRepository->save($personal, true);

            return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personal/edit.html.twig', [
            'personal' => $personal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'personal_delete', methods: ['POST'])]
    public function delete(Request $request, Personal $personal, PersonalRepository $personalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $personal->getId(), $request->request->get('_token'))) {
            $personalRepository->remove($personal, true);
        }

        return $this->redirectToRoute('personal_index', [], Response::HTTP_SEE_OTHER);
    }
}
