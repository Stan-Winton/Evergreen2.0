<?php

namespace App\Controller;

use App\Entity\Comercios;
use App\Form\RegistroEmpresaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistroEmpresaController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/registro_empresa', name: 'registro_empresa')]
    public function registro_empresa(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $usuario = new Comercios();
        $registroForm = $this->createForm(RegistroEmpresaType::class, $usuario);
        $registroForm->handleRequest($request);
        if ($registroForm->isSubmitted() && $registroForm->isValid()) {
            $plaintextPassword = $registroForm->get('password')->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $usuario,
                $plaintextPassword
            );
            $usuario->setPassword($hashedPassword);
            $usuario->setROLES(['ROLE_USER']);
            $this->em->persist($usuario);
            $this->em->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('registro_empresa/index.html.twig', [
        'registroForm' => $registroForm->createView()
        ]);
    }
}
