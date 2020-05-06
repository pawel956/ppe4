<?php

namespace App\Security;

use App\Entity\Utilisateur;
use App\Security\Exception\AccountDisabledException;
use App\Security\Exception\AccountNotActivatedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof Utilisateur) {
            return;
        }

        if (!$user->getActif()) {
            throw new AccountDisabledException();
        }

        if (!is_null($user->getToken())) {
            throw new AccountNotActivatedException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}