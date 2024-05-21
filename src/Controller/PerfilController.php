<?php
// src/Controller/PerfilController.php

namespace App\Controller;

use App\Form\PerfilType;
use App\Form\UsuarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PerfilController extends AbstractController
{
    #[Route('/perfil', name:"perfil")]
    public function index(UserInterface $user, Request $request, EntityManagerInterface $em): Response
    {
        $fotoForm = $this->createForm(PerfilType::class);
        $fotoForm->handleRequest($request);
        if ($fotoForm->isSubmitted() && $fotoForm->isValid()) {
            /** @var UploadedFile $file */
            $file = $fotoForm['foto']->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // Reemplazo de transliterator_transliterate
                $safeFilename = preg_replace('/[^A-Za-z0-9_]/', '', $originalFilename);
                $newFilename = strtolower($safeFilename).'-'.uniqid().'.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $user->setFoto($newFilename);
                $em->flush();
            }
        }

        return $this->render('perfil/index.html.twig', [
            'usuario' => $user,
            'fotoForm' => $fotoForm->createView(),
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