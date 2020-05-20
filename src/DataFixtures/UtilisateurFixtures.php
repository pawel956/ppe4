<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use App\Service\UtilisateurService;
use Cocur\Slugify\SlugifyInterface;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UtilisateurFixtures extends Fixture implements DependentFixtureInterface
{
    protected $utilisateurService;
    protected $slugify;

    public function __construct(UtilisateurService $utilisateurService, SlugifyInterface $slugify)
    {
        $this->utilisateurService = $utilisateurService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesUtilisateurs = [
            [
                'nom' => 'Martinez',
                'prenom' => 'Manuel',
                'courriel' => 'user@gmail.com',
                'telephone' => '0101010101',
                'dateNaissance' => new DateTime('1976-01-01'),
                'mdp' => '123456',
                'idGenre' => $this->getReference('genrehomme')
            ],
            [
                'roles' => ['ROLE_ADMIN'],
                'nom' => 'Nadal',
                'prenom' => 'Cyrille',
                'courriel' => 'admin@gmail.com',
                'telephone' => '0202020202',
                'dateNaissance' => new DateTime('1976-01-02'),
                'mdp' => '123456',
                'idGenre' => $this->getReference('genrehomme')
            ]
        ];

        foreach ($lesUtilisateurs as $unUtilisateur) {
            $utilisateur = new Utilisateur();

            if(isset($unUtilisateur['roles'])){
                $utilisateur->setRoles($unUtilisateur['roles']);
            }

            $utilisateur->setNom($unUtilisateur['nom']);
            $utilisateur->setPrenom($unUtilisateur['prenom']);
            $utilisateur->setEmail($unUtilisateur['courriel']);
            $utilisateur->setTelephone($unUtilisateur['telephone']);
            $utilisateur->setDateNaissance($unUtilisateur['dateNaissance']);
            $utilisateur->setPlainPassword($unUtilisateur['mdp']);
            $utilisateur->setIdGenre($unUtilisateur['idGenre']);
            $this->utilisateurService->save($utilisateur);

            $this->addReference('utilisateur' . $this->slugify->slugify($utilisateur->getEmail()), $utilisateur);
        }
    }

    public function getDependencies()
    {
        return array(
            GenreFixtures::class
        );
    }
}
