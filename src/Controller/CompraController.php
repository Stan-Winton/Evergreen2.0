<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComerciosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CompraController extends AbstractController
{
    #[Route('/compra', name: 'app_compra', methods: ['GET', 'POST'])]
    public function index(Request $request, ComerciosRepository $comerciosRepository, SessionInterface $session): Response
    {
        $comercios = $session->get('comercios', []);
        $error = null;

        if ($request->isMethod('POST')) {
            $codigoPostal = $request->request->get('codigoPostal');

            if (!empty($codigoPostal)) {
                $comercios = $comerciosRepository->findByCodigoPostal($codigoPostal);

                if (empty($comercios)) {
                    $this->addFlash('error', 'No hay comercios.');
                } else {
                    $session->set('comercios', $comercios);
                }
            } else {
                $this->addFlash('error', 'Se necesita un código postal.');
            }

            return $this->redirectToRoute('app_compra');
        }

        $error = $session->getFlashBag()->get('error', []);
        $error = reset($error); // Get the first error message

        // Render the view first, then clear the 'comercios' from the session
        $response = $this->render('compra/index.html.twig', [
            'comercios' => $comercios,
            'error' => $error,
        ]);

        $session->remove('comercios');

        return $response;
    }
}