<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // Asegúrate de incluir esta línea
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils, Request $request): Response // Añade Request $request aquí
    {
        // Inicia la sesión
        $request->getSession()->start();

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
       
    }
}