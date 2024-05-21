<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Productos;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductosRepository;
use Symfony\Component\Security\Core\Security;

class MisProductosController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/mis_productos', name: 'mis_productos')]
    public function index(ProductosRepository $productosRepository): Response
    {
        $comercio = $this->security->getUser();

        $productos = $productosRepository->findBy(['comercios' => $comercio]);

        return $this->render('mis_productos/index.html.twig', [
            'controller_name' => 'MisProductosController',
            'productos' => $productos,
        ]);
    }
}