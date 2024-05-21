<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use App\Entity\Usuario;
use App\Entity\Comercios;

class LoginSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function onLoginSuccess(LoginSuccessEvent $event)
    {
        $user = $event->getUser();

        if ($user instanceof Usuario) {
            $response = new RedirectResponse($this->urlGenerator->generate('app_home'));
        } elseif ($user instanceof Comercios) {
            $response = new RedirectResponse($this->urlGenerator->generate('inicio_empresa'));
        }

        if (isset($response)) {
            $event->setResponse($response);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
        ];
    }
}
?>