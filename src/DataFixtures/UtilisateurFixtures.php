<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Service\UtilisateurService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture implements DependentFixtureInterface
{
    protected $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function load(ObjectManager $entityManager)
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setNom('Martinez');
        $utilisateur->setPrenom('Manuel');
        $utilisateur->setEmail('user@gmail.com');
        $utilisateur->setTelephone('0101010101');
        $utilisateur->setDateNaissance(new \DateTime('1976-01-01'));
        $utilisateur->setPlainPassword('123456');
        $utilisateur->setIdGenre($this->getReference('genre'));
        $this->utilisateurService->save($utilisateur);

        $utilisateur = new Utilisateur();
        $utilisateur->setRoles(['ROLE_ADMIN']);
        $utilisateur->setNom('Nadal');
        $utilisateur->setPrenom('Cyrille');
        $utilisateur->setEmail('admin@gmail.com');
        $utilisateur->setTelephone('0202020202');
        $utilisateur->setDateNaissance(new \DateTime('1976-01-02'));
        $utilisateur->setPlainPassword('123456');
        $utilisateur->setIdGenre($this->getReference('genre'));
        $this->utilisateurService->save($utilisateur);
    }

    public function getDependencies()
    {
        return array(
            GenreFixtures::class
        );
    }
}
