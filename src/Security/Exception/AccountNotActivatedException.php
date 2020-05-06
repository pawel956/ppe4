<?php

namespace App\Security\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class AccountNotActivatedException extends AccountStatusException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'Votre compte n\'est pas activé. Veuillez suivre les instructions dans le mail reçu après votre inscription.';
    }
}