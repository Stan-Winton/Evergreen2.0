<?php

namespace App\Controller;

use App\Form\Login2FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Login2Controller extends AbstractController
{
    #[Route('/login2', name: 'app_login2')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(Login2FormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $tipo_usuario = $data['tipo_usuario'];

            if ($tipo_usuario === 'particular') {
                // Redirigir a la ruta para usuarios particulares
                return $this->redirectToRoute('registro');
            } elseif ($tipo_usuario === 'empresa') {
                // Redirigir a la ruta para empresas
                return $this->redirectToRoute('registro_empresa');
            }
        }

        return $this->render('login2/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
