<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\ComercioType; // Asegúrate de que este namespace es correcto
use Doctrine\ORM\EntityManagerInterface;

class PerfilComercioController extends AbstractController
{
    #[Route('/perfil/comercio', name: 'perfil_comercio')]
    public function index(UserInterface $user): Response
    {
        // Asegúrate de que el usuario es una instancia de Comercios
        if (!$user instanceof \App\Entity\Comercios) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('perfil_comercio/index.html.twig', [
            'comercio' => $user,
        ]);
    }

    #[Route('/perfil/comercio/editar', name: 'editar_perfil_comercio')]
    public function editar(UserInterface $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Asegúrate de que el usuario es una instancia de Comercios
        if (!$user instanceof \App\Entity\Comercios) {
            throw $this->createAccessDeniedException();
        }

        // Crea el formulario
        $form = $this->createForm(ComercioType::class, $user);

        // Maneja la solicitud
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Guarda los cambios
            $entityManager->flush();

            return $this->redirectToRoute('perfil_comercio');
        }

        return $this->render('perfil_comercio/editar_comercio.html.twig', [
            'comercio' => $user,
            'form' => $form->createView(),
        ]);
    }
}