<?php

namespace App\Controller;

use App\Entity\Pedidos;
use App\Entity\Productos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarritoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function calcularTotalCarrito($carrito)
    {
        $total = 0;
        foreach ($carrito as $id => $cantidad) {
            $producto = $this->entityManager->getRepository(Productos::class)->find($id);
            if ($producto) {
                $total += $producto->getPrecio() * $cantidad;
            }
        }
        return $total;
    }

    #[Route('/carrito', name: 'carrito')]
    public function index(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $carrito = $request->getSession()->get('carrito', []);
        $total = $this->calcularTotalCarrito($carrito);
        $request->getSession()->set('total', $total);

        $productos = [];
        foreach ($carrito as $id => $cantidad) {
            $producto = $this->entityManager->getRepository(Productos::class)->find($id);
            if ($producto) {
                $productos[] = $producto;
            }
        }

        return $this->render('carrito/index.html.twig', [
            'carrito' => $carrito,
            'total' => $total,
            'productos' => $productos,
        ]);
    }

    #[Route('/carrito/actualizar/{id}', name: 'actualizar_carrito', methods: ['POST'])]
    public function actualizar(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $newQuantity = $request->request->get('cantidad');
        $carrito = $request->getSession()->get('carrito', []);
        $stockOriginal = $request->getSession()->get('stockOriginal', []);

        if (isset($carrito[$id])) {
            $producto = $this->entityManager->getRepository(Productos::class)->find($id);
            if ($producto) {
                if ($newQuantity > $producto->getStock() + $carrito[$id]) {
                    $this->addFlash('error', 'Stock no disponible');
                    return $this->redirectToRoute('carrito');
                }
                $producto->setStock($producto->getStock() - $newQuantity + $carrito[$id]);
                $this->entityManager->persist($producto);
                $this->entityManager->flush();
            }
        }

        $carrito[$id] = $newQuantity;
        if (isset($producto)) {
            $stockOriginal[$id] = $producto->getStock();
        }
        $request->getSession()->set('carrito', $carrito);
        $request->getSession()->set('stockOriginal', $stockOriginal);

        $total = $this->calcularTotalCarrito($carrito);
        $request->getSession()->set('total', $total);

        return $this->redirectToRoute('carrito');
    }

    #[Route('/carrito/eliminar/{id}', name: 'eliminar_del_carrito')]
    public function eliminar(int $id, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        $carrito = $request->getSession()->get('carrito', []);
        $stockOriginal = $request->getSession()->get('stockOriginal', []);

        if (isset($carrito[$id])) {
            $producto = $this->entityManager->getRepository(Productos::class)->find($id);
            if ($producto) {
                $producto->setStock($producto->getStock() + $carrito[$id]);
                $this->entityManager->persist($producto);
                $this->entityManager->flush();
            }
            unset($carrito[$id]);
            unset($stockOriginal[$id]);
        }

        $request->getSession()->set('carrito', $carrito);
        $request->getSession()->set('stockOriginal', $stockOriginal);

        $total = $this->calcularTotalCarrito($carrito);
        $request->getSession()->set('total', $total);

        if (count($carrito) > 0) {
            return $this->redirectToRoute('carrito');
        } else {
            return $this->redirectToRoute('compra_online');
        }
    }

    #[Route('/realizar_pedido', name: 'realizar_pedido', methods: ['POST'])]
public function realizarPedido(Request $request)
{
    $carrito = $request->getSession()->get('carrito', []);

    if (!$carrito) {
        $this->addFlash('error', 'No hay productos en el carrito');
        return $this->redirectToRoute('carrito');
    }

    $pedido = new Pedidos();
    $pedido->setUsuario($this->getUser()); // Asume que el usuario actual es el usuario que realiza el pedido

    $comercio = null;
    foreach ($carrito as $id => $cantidad) {
        $producto = $this->entityManager->getRepository(Productos::class)->find($id);
        if ($producto) {
            for ($i = 0; $i < $cantidad; $i++) {
                $pedido->addProducto($producto);
            }
            if (!$comercio) {
                $comercio = $producto->getComercios();
            }
        }
    }

    if ($comercio) {
        $pedido->setComercios($comercio);
    }

    $pedido->setFecha(new \DateTime()); // Asume que tienes un campo fecha en tu entidad Pedidos
    $pedido->setTotal($request->getSession()->get('total')); // Asume que tienes un campo total en tu entidad Pedidos

    $this->entityManager->persist($pedido);
    $this->entityManager->flush();

    // Vacía el carrito
    $request->getSession()->set('carrito', []);

    $this->addFlash('success', 'Su pedido se ha realizado con éxito');
    return $this->redirectToRoute('app_home');
}
}