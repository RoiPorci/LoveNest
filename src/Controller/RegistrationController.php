<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FinalUserType;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param AppAuthenticator $authenticator
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function register(
        Request $request, UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator,
        AuthenticationUtils $authenticationUtils
    ): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user, [
            'validation_groups' => ['registration'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setDateCreated(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @IsGranted("ROLE_ANONYMOUS")
     * @Route("/register/2", name="app_final_register")
     * @param Request $request
     * @param GuardAuthenticatorHandler $guardHandler
     * @param AppAuthenticator $authenticator
     * @return Response
     */
    public function finishRegistration(Request $request, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(FinalUserType::class, $user, [
            'validation_groups' => ['completeRegistration'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setDateUpdated(new \DateTime());
            $user->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Bienvenue ' . $user->getUsername() . '!');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/final_registration.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
