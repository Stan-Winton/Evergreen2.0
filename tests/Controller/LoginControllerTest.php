<?php

namespace App\Tests\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        // Crea un nuevo usuario de prueba
        $testUser = new Usuario();
        $testUser->setEmail('test@example.com');
        $testUser->setPassword('testpassword'); // Asegúrate de establecer un password
        $testUser->setNombre('Test User'); // Asegúrate de establecer un nombre
        $testUser->setDireccion('Test Address'); // Asegúrate de establecer una dirección
        $testUser->setTelefono('1234567890'); // Asegúrate de establecer un teléfono
        $testUser->setFecha(new \DateTime()); // Asegúrate de establecer una fecha

        // Guarda el usuario en la base de datos
        $this->entityManager->persist($testUser);
        $this->entityManager->flush();
    }

    protected function tearDown(): void
    {
        // Recuperar el usuario de la base de datos
        $repo = $this->entityManager->getRepository(Usuario::class);
        $testUser = $repo->findOneBy(['email' => 'test@example.com']);

        // Si el usuario existe, borrarlo
        if ($testUser) {
            $this->entityManager->remove($testUser);
            $this->entityManager->flush();
        }

        parent::tearDown();
    }

    public function testLoginWithValidUser()
    {
        // Recuperar el usuario de la base de datos
        $repo = $this->entityManager->getRepository(Usuario::class);
        $testUser = $repo->findOneBy(['email' => 'test@example.com']);

        // Simula una autenticación exitosa
        $this->client->loginUser($testUser);

        // Comprueba que el usuario está autenticado
        $user = $this->client->getContainer()->get('security.token_storage')->getToken()->getUser();
        $this->assertNotNull($user);
    }

    public function testLogout()
    {
        // Recuperar el usuario de la base de datos
        $repo = $this->entityManager->getRepository(Usuario::class);
        $testUser = $repo->findOneBy(['email' => 'test@example.com']);

        // Simula una autenticación exitosa
        $this->client->loginUser($testUser);

        // Simula un logout
        $this->client->request('GET', '/logout');

        // Comprueba que el usuario ya no está autenticado
        $user = $this->client->getContainer()->get('security.token_storage')->getToken();
        $this->assertNull($user);
        
    }
}