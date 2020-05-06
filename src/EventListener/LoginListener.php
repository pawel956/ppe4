<?php
// https://rihards.com/2018/symfony-login-event-listener/
namespace App\EventListener;

use App\Service\UtilisateurService;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use App\Entity\Utilisateur;

class LoginListener
{
    private $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        /** @var Utilisateur $user */
        $user = $event->getAuthenticationToken()->getUser();

        // Update your field here.
        $user->setDateDerniereConnexion(new \DateTime());

        // Persist the data to database.
        $this->utilisateurService->save($user);
    }
}