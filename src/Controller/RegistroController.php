<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    
    {
        $this->em = $em;
    }

    #[Route('/registro', name: 'registro')]
    public function registro(Request $request): Response
    {
        $usuario = new Usuario();
        $registroForm = $this->createForm(RegistroType::class, $usuario);
        $registroForm->handleRequest($request);
        if ($registroForm->isSubmitted() && $registroForm->isValid()) {
            $fecha = $registroForm->get('fecha')->getData();
            $usuario->setfecha($fecha);
            $this->em->persist($usuario);
            $this->em->flush();
            return $this->redirectToRoute('app_home');

        }

        return $this->render('registro/index.html.twig', [
            'registroForm' => $registroForm->createView()
        ]);
    }
}
