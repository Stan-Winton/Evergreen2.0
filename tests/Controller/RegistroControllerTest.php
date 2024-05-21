<?php

namespace App\Tests\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistroControllerTest extends WebTestCase
{
    public function testRegistroSuccess()
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Crear un nuevo objeto Usuario
        $usuario = new Usuario();
        $usuario->setNombre('Test Name');
        $usuario->setDireccion('Test Address');
        $usuario->setTelefono('1234567890'); // Asegúrate de que este método exista en tu entidad Usuario
        $usuario->setEmail('test@example.com');
        $usuario->setRoles(['ROLE_USER']);
        $usuario->setFecha(new \DateTime());

        // Hash the password
        $passwordHasher = $client->getContainer()->get(UserPasswordHasherInterface::class);
        $hashedPassword = $passwordHasher->hashPassword($usuario, 'testpassword');
        $usuario->setPassword($hashedPassword);

        // Persistir el usuario
        $entityManager->persist($usuario);
        $entityManager->flush();

        // Comprobar que el usuario se ha guardado en la base de datos
        $repo = $entityManager->getRepository(Usuario::class);
        $testUser = $repo->findOneBy(['email' => 'test@example.com']);

        $this->assertNotNull($testUser);
        $this->assertEquals('test@example.com', $testUser->getEmail());
        $this->assertEquals('Test Name', $testUser->getNombre());
        $this->assertEquals('Test Address', $testUser->getDireccion());
        $this->assertEquals('1234567890', $testUser->getTelefono()); // Comprobar también el teléfono
    }
}