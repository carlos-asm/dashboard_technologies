<?php

namespace App\Infrastructure\Event;

use App\Domain\User\Event\UserRegisteredEvent;
use App\Domain\User\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegisteredEventHandler implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisteredEvent::NAME => 'onUserRegistered',
        ];
    }

    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        // Simulate sending a welcome email
        $user = $event->getUser();
        $this->sendWelcomeEmail($user);
    }

    private function sendWelcomeEmail(User $user): void
    {
        // Simulación de envío de correo
        $email = $user->getEmail()->getValue();
        $subject = "Bienvenido a nuestra plataforma";
        $message = "Hola {$user->getName()->getValue()}, ¡gracias por registrarte!";

        echo "Enviando correo a: $email\n";
        echo "Asunto: $subject\n";
        echo "Mensaje: $message\n";
    }
}