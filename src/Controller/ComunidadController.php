<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComunidadController extends AbstractController
{
    #[Route('/comunidad', name: 'app_comunidad')]
    public function index(): Response
    {
        return $this->render('comunidad/index.html.twig', [
            'controller_name' => 'ComunidadController',
        ]);
    }
}
