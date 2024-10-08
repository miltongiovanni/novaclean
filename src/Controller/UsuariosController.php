<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PerfilesRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
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
        if (!$this->isGranted('VIEW', 'ADMINISTRACIÓN')) {
            return $this->redirectToRoute('home');
        }
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
            'users' => $userRepository->findAll(),
        ]);
    }


    #[Route('/usuario/nuevo', name: 'user_new', methods: ['GET'])]
    public function new(Request $request, PerfilesRepository $perfilesRepository): Response
    {
        if (!$this->isGranted('EDIT', 'ADMINISTRACIÓN')) {
            return $this->redirectToRoute('home');
        }
        $perfiles = $perfilesRepository->findAll();
        $slug = Uuid::v6();
        return $this->render('usuarios/new.html.twig', [
            'action' => 'insert',
            'perfiles' => $perfiles,
            'slug' => $slug,
        ]);
    }

    #[Route('/usuario/{slug}/editar', name: 'user_edit', methods: ['GET'])]
    public function edit(Request $request, string $slug, UserRepository $userRepository, PerfilesRepository $perfilesRepository): Response
    {
        $perfiles = $perfilesRepository->findAll();
        $user = $userRepository->findOneBy(['slug' => Uuid::fromString($slug)]);
        //dd($user->getSlug()->toRfc4122());

        return $this->render('usuarios/edit.html.twig', [
            'user' => $user,
            'perfiles' => $perfiles,
            'action' => 'update',
        ]);
    }

    #[Route('/usuario/{slug}/activar', name: 'user_activate', methods: ['GET'])]
    public function activate(Request $request, string $slug, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['slug' => Uuid::fromString($slug)]);
        $user->setActivo(true);
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Usuario activado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Usuario');
        return $this->redirectToRoute('usuarios', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/usuario/{slug}/desactivar', name: 'user_deactivate', methods: ['GET'])]
    public function deactivate(Request $request, string $slug, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['slug' => Uuid::fromString($slug)]);
        $user->setActivo(false);
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $this->addFlash('success', 'Usuario desactivado correctamente');
        //$this->addFlash('error', ' Error al actualizar el Usuario');
        return $this->redirectToRoute('usuarios', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/usuario/{slug}/actualizar', name: 'user_update', methods: ['POST'])]
    public function update(Request $request, string $slug, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, UserRepository $userRepository, PerfilesRepository $perfilesRepository): Response
    {
        $action = $request->request->get('action');
        $user = $userRepository->findOneBy(['slug' => Uuid::fromString($slug)]);
        if (!$user) {
            $user = new User();
            $user->setSlug(Uuid::fromString($slug));
        }

        $user->setEmail(trim($request->request->get('email')));
        $user->setNombre(trim($request->request->get('nombre')));
        $user->setApellido(trim($request->request->get('apellido')));
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
        $user->setFCreacion(Carbon::now());
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
            $email->from(new Address('no-reply@novaclean.com.co', 'Novaclean Service S.A.S.'));
            $email->to(new Address($user->getEmail(), $user->getNombre() . ' ' . $user->getApellido()));
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

    #[Route('/usuario/{slug}/borrar', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, string $slug, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneBy(['slug' => Uuid::fromString($slug)]);
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
