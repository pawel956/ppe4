<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Service\AdresseService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdresseFixtures extends Fixture implements DependentFixtureInterface
{
    protected $adresseService;
    protected $slugify;

    public function __construct(AdresseService $adresseService, SlugifyInterface $slugify)
    {
        $this->adresseService = $adresseService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesAdresses = [
            [
                'libelle' => 'Rue de la gare',
                'idVille' => $this->getReference('villeagde')
            ],
            [
                'libelle' => 'Avenue des Champs-Élysées',
                'idVille' => $this->getReference('villeparis-8e-arrondissement')
            ]
        ];

        foreach ($lesAdresses as $uneAdresse) {
            $adresse = new Adresse();
            $adresse->setLibelle($uneAdresse['libelle']);
            $adresse->setIdVille($uneAdresse['idVille']);
            $this->adresseService->save($adresse);

            $this->addReference('adresse' . $this->slugify->slugify($adresse->getLibelle()), $adresse);
        }
    }

    public function getDependencies()
    {
        return array(
            VilleFixtures::class
        );
    }
}
