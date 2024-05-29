<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductosRepository;

class CompraOnlineController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compra_online', name: 'compra_online')]
    public function index(Request $request, ProductosRepository $productosRepository): Response
    {
        $q = $request->query->get('q');
        $tipoProducto = $request->query->get('tipoProducto');

        $productos = [];
        $noStockMessage = null;
        $busquedaRealizada = false;
        if ($q) {
            $productos = $productosRepository->findByNombre($q);
            if (empty($productos)) {
                $noStockMessage = "No hay stock del producto buscado.";
            }
            $busquedaRealizada = true;
        } elseif ($tipoProducto) {
            $productos = $productosRepository->findByTipoProducto($tipoProducto);
            $busquedaRealizada = true;
        }

        $tiposProducto = $productosRepository->findDistinctTiposProducto();

        return $this->render('compra_online/index.html.twig', [
            'productos' => $productos,
            'q' => $q,
            'noStockMessage' => $noStockMessage,
            'tiposProducto' => $tiposProducto,
            'busquedaRealizada' => $busquedaRealizada,
        ]);
    }

    #[Route('/compra_online/{id}/disminuir-stock', name: 'disminuir_stock', methods: ['POST'])]
    public function disminuirStock($id, ProductosRepository $productosRepository, EntityManagerInterface $entityManager): Response
    {
        $producto = $productosRepository->find($id);

        if (!$producto) {
            throw $this->createNotFoundException('El producto no existe');
        }

        $producto->setStock($producto->getStock() - 1);
        $entityManager->persist($producto);
        
        $entityManager->flush();

        return new JsonResponse(['stock' => $producto->getStock()]);
    }

    #[Route('/compra_online/agregar/{id}', name: 'agregar_al_carrito', methods: ['POST'])]
    public function agregarAlCarrito($id, Request $request, ProductosRepository $productosRepository, EntityManagerInterface $entityManager): Response
    {
        $producto = $productosRepository->find($id);
    
        if (!$producto) {
            throw $this->createNotFoundException('El producto no existe');
        }
    
        $cantidad = intval($request->request->get('cantidad'));
        if ($producto->getStock() < $cantidad) {
            return new JsonResponse(['error' => 'No hay suficiente stock del producto'], Response::HTTP_BAD_REQUEST);
        }

        $session = $request->getSession();
        $carrito = $session->get('carrito', []);
    
        if (isset($carrito[$id])) {
            $carrito[$id] += $cantidad;
        } else {
            $carrito[$id] = $cantidad;
        }
    
        $session->set('carrito', $carrito);
    
        $producto->setStock($producto->getStock() - $cantidad);
        $entityManager->persist($producto);
        $entityManager->flush();
    
        return $this->redirect($request->headers->get('referer'));
    }
    

    #[Route('/compra_online/ver_carrito', name: 'ver_carrito')]
    public function verCarrito(Request $request): Response
    {
        $session = $request->getSession();
        $carrito = $session->get('carrito', []);

        return new JsonResponse($carrito);
    }
}