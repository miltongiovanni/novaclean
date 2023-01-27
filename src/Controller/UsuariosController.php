<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PerfilesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class UsuariosController extends AbstractController
{
    private $verifyEmailHelper;
    private $mailer;

    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
    }

    #[Route('/usuarios', name: 'usuarios')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
            'users' => $userRepository->findAll(),
        ]);
    }


    #[Route('/usuario/nuevo', name: 'user_new', methods: ['GET'])]
    public function new(Request $request, PerfilesRepository $perfilesRepository): Response
    {
        $perfiles = $perfilesRepository->findAll();

        return $this->render('usuarios/new.html.twig', [
            'action' => 'insert',
            'perfiles' => $perfiles,

        ]);
    }

    #[Route('/usuario/{id}/editar', name: 'user_edit', methods: ['GET'])]
    public function edit(Request $request, int $id, UserRepository $userRepository, PerfilesRepository $perfilesRepository): Response
    {
        $perfiles = $perfilesRepository->findAll();
        $user = $userRepository->find($id);

        return $this->render('usuarios/edit.html.twig', [
            'user' => $user,
            'perfiles' => $perfiles,
            'action' => 'update',
        ]);
    }

    #[Route('/usuario/{id}/activar', name: 'user_activate', methods: ['GET'])]
    public function activate(Request $request, int $id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $user->setActivo(true);
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Usuario activado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Usuario');
        return $this->redirectToRoute('usuarios', [], Response::HTTP_SEE_OTHER);

    }
    #[Route('/usuario/{id}/desactivar', name: 'user_deactivate', methods: ['GET'])]
    public function deactivate(Request $request, int $id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $user->setActivo(false);
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Usuario desactivado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Usuario');
        return $this->redirectToRoute('usuarios', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/usuario/{id}/actualizar', name: 'user_update', methods: ['POST'])]
    public function update(Request $request, int $id, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, PerfilesRepository $perfilesRepository): Response
    {
        if ($id == 0) {
            $user = new User();
        } else {
            $user = $userRepository->find($id);
        }
        $action = $request->request->get('action');
        $user->setEmail($request->request->get('email'));
        $perfilValue = $request->request->get('role');
        $activo = $request->request->get('activo', false);
        $perfilArray = explode('-', $perfilValue);
        $perfil = $perfilesRepository->find($perfilArray[0]);
        $user->setRoles([$perfilArray[1]]);
        $user->setPerfil($perfil);
        $plaintextPassword = $request->request->get('password', false);
        $plaintextPasswordConfirmation = $request->request->get('password-confirmation', false);
        if ($plaintextPassword) {
            if ($plaintextPassword == $plaintextPasswordConfirmation) {
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $plaintextPassword
                );
                $user->setPassword($hashedPassword);
            }
        }
        $user->setIsVerified(false);
        $user->setActivo($activo);
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        if ($action == 'insert') {
            // generate a signed url and email it to the user

            $signatureComponents = $this->verifyEmailHelper->generateSignature(
                'registration_confirmation_route',
                $user->getId(),
                $user->getEmail()
            );
            $email = new TemplatedEmail();
            $email->from(new Address('contacto@novaquim.com', 'Industrias Novaquim S.A.S.'));
            $email->to($user->getEmail());
            $email->subject('Please Confirm your Email');
            $email->htmlTemplate('registration/confirmation_email.html.twig');
            $email->context(['signedUrl' => $signatureComponents->getSignedUrl()]);

            $this->mailer->send($email);
            $this->addFlash('success', 'Usuario creado correctamente');
        } else {
            $this->addFlash('success', 'Usuario actualizado correctamente');
        }

        //$this->addFlash('error', ' Error al actualizar el Usuario');
        return $this->redirectToRoute('usuarios', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/usuario/{id}/borrar', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('usuarios', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/verify', name: 'registration_confirmation_route')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        // Do not get the User's Id or Email Address from the Request object
        try {
            $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('usuarios');
        }
        $user->setIsVerified(true);
        $user->setActivo(true);
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();



        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('home');
    }
}
