<?php
namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/registro', name: 'registro')]
    public function registro(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $usuario = new Usuario();
        $registroForm = $this->createForm(RegistroType::class, $usuario);

        $registroForm->handleRequest($request);

        if ($registroForm->isSubmitted() && $registroForm->isValid()) {
            $email = $registroForm->get('email')->getData();

            // Comprobar si el correo electrónico ya existe
            $existingUser = $this->em->getRepository(Usuario::class)->findOneBy(['email' => $email]);
            if ($existingUser) {
                $this->addFlash('error', 'Este correo electrónico ya está en uso.');
                return $this->redirectToRoute('registro');
            }

            $plaintextPassword = $registroForm->get('password')->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $usuario,
                $plaintextPassword
            );
            $usuario->setPassword($hashedPassword);
            $usuario->setRoles(['ROLE_USER']);
            $fecha = $registroForm->get('fecha')->getData();
            $usuario->setfecha($fecha);
            $this->em->persist($usuario);
            $this->em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('registro/index.html.twig', [
            'registroForm' => $registroForm->createView()
        ]);
    }
}