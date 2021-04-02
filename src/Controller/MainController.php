<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function home(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/home.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/about-us", name="main_about_us")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function aboutUs(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/about_us.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/conditions-generales-d-utilisation", name="main_cgu")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function cgu(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/cgu.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/mentions-legales", name="main_legal_notice")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function legalNotice(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/legal_notice.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }
}
