<?php
namespace App\Security;

use App\Entity\Usuario;
use App\Entity\Comercios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class AppUserProvider implements UserProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->entityManager
            ->getRepository(Usuario::class)
            ->findOneBy(['email' => $identifier]);

        if ($user) {
            return $user;
        }

        $comercio = $this->entityManager
            ->getRepository(Comercios::class)
            ->findOneBy(['email' => $identifier]);

        if ($comercio) {
            return $comercio;
        }

        throw new UserNotFoundException('Username could not be found.');
    }

    public function refreshUser(UserInterface $user)
    {
        if ($user instanceof Usuario) {
            $refreshedUser = $this->entityManager->getRepository(Usuario::class)->find($user->getId());
        } elseif ($user instanceof Comercios) {
            $refreshedUser = $this->entityManager->getRepository(Comercios::class)->find($user->getId());
        }

        if (!$refreshedUser) {
            throw new UserNotFoundException(sprintf('User with ID "%s" could not be reloaded.', $user->getId()));
        }

        return $refreshedUser;
    }

    public function supportsClass(string $class)
    {
        return in_array($class, [Usuario::class, Comercios::class]);
    }
}
?>