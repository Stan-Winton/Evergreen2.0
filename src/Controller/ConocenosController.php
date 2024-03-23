<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConocenosController extends AbstractController
{
    #[Route('/conocenos', name: 'app_conocenos')]
    public function index(): Response
    {
        return $this->render('conocenos/index.html.twig', [
            'controller_name' => 'ConocenosController',
        ]);
    }
}
