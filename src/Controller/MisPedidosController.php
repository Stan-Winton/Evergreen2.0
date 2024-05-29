<?php

namespace App\Controller;

use App\Entity\Pedidos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MisPedidosController extends AbstractController
{
    #[Route('/mis_pedidos', name: 'mis_pedidos')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $comercio = $this->getUser(); // Asume que el usuario autenticado es un comercio

        $pedidos = $entityManager->getRepository(Pedidos::class)->findBy(['comercios' => $comercio]);

        return $this->render('mis_pedidos/index.html.twig', [
            'controller_name' => 'MisPedidosController',
            'pedidos' => $pedidos,
        ]);
    }
}