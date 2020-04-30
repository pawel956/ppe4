<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Service\UtilisateurService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture
{
    protected $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function load(ObjectManager $entityManager)
    {
        $Utilisateur = new Utilisateur();
        $Utilisateur->setEmail('radyna.pawel@gmail.com');
        $Utilisateur->setPlainPassword('toto');
        $this->utilisateurService->save($Utilisateur);
    }
}
