<?php

namespace App\Controller;

use App\Entity\Productos;
use App\Repository\ProductosRepository;
use App\Repository\PedidosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class InicioEmpresaController extends AbstractController
{
    private $security;
    private $pedidosRepository;

    public function __construct(Security $security, PedidosRepository $pedidosRepository)
    {
        $this->security = $security;
        $this->pedidosRepository = $pedidosRepository;
    }

    #[Route('/inicio_empresa', name: 'inicio_empresa', methods: ['GET'])]
    public function index(ProductosRepository $productosRepository): Response
    {
        $comercio = $this->security->getUser();

        $productos = $productosRepository->findBy(['comercios' => $comercio], ['id' => 'DESC'], 4);
         // Invierte el array de productos
        $productos = array_reverse($productos);

        // Obtén los últimos 4 pedidos
        $pedidos = $this->pedidosRepository->findBy(['comercios' => $comercio], ['id' => 'DESC'], 4);

        return $this->render('inicio_empresa/index.html.twig', [
            'controller_name' => 'InicioEmpresaController',
            'productos' => $productos,
            'pedidos' => $pedidos,  // Añade los pedidos a la plantilla
        ]);
    }

    #[Route('/inicio_empresa', name: 'inicio_empresa_post', methods: ['POST'])]
    public function subirProducto(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comercio = $this->security->getUser();

        $producto = new Productos();
        $producto->setNombre($request->request->get('productoNombre'));
        $producto->setDescripcion($request->request->get('productoDescripcion'));
        $producto->setPrecio((int) $request->request->get('productoPrecio'));
        $producto->setStock((int) $request->request->get('productoStock'));
        $producto->setTipoProducto($request->request->get('productoTipo'));
        $producto->setComercios($comercio);

        // Manejar la carga de la imagen
        $file = $request->files->get('productoImagen');
        if ($file) {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads_directory'), $fileName);
            $producto->setImagen($fileName);
        }

        try {
            $entityManager->persist($producto);
            $entityManager->flush();
        } catch (\Exception $e) {
            error_log('Error al guardar el producto: ' . $e->getMessage());
            return $this->redirectToRoute('error');
        }

        return $this->redirectToRoute('inicio_empresa');
    }
}