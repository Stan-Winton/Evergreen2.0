<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MisPedidosController extends AbstractController
{
    #[Route('/mis_pedidos', name: 'mis_pedidos')]
    public function index(): Response
    {
        return $this->render('mis_pedidos/index.html.twig', [
            'controller_name' => 'MisPedidosController',
        ]);
    }
}
