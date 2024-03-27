<?php
// src/Controller/PerfilController.php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\UsuarioType;

class PerfilController extends AbstractController
{
    #[Route('/perfil', name:"perfil")]
    public function index(UserInterface $user): Response
    {
        return $this->render('perfil/index.html.twig', [
            'usuario' => $user,
        ]);
    }

    #[Route("/perfil/editar", name:"perfil_editar")]
    public function editar(Request $request, UserInterface $user, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $form = $this->createForm(UsuarioType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('perfil');
        }

        return $this->render('perfil/editar.html.twig', [
            'usuario' => $user,
            'form' => $form->createView(),
        ]);
    }

    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
?>