<?php

namespace App\DataFixtures;

use App\Entity\Propriete;
use App\Service\ProprieteService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProprieteFixtures extends Fixture implements DependentFixtureInterface
{
    protected $proprieteService;

    public function __construct(ProprieteService $proprieteService)
    {
        $this->proprieteService = $proprieteService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesProprietes = [
            [
                'numeroRue' => '11',
                'idAdresse' => $this->getReference('adresserue-de-la-gare')
            ],
            [
                'numeroRue' => '54',
                'idAdresse' => $this->getReference('adresseavenue-des-champs-elysees')
            ]
        ];

        foreach ($lesProprietes as $unePropriete) {
            $propriete = new Propriete();
            $propriete->setNumeroRue($unePropriete['numeroRue']);
            $propriete->setIdAdresse($unePropriete['idAdresse']);
            $this->proprieteService->save($propriete);

            $this->addReference('propriete' . $propriete->getNumeroRue(), $propriete);
        }
    }

    public function getDependencies()
    {
        return array(
            AdresseFixtures::class
        );
    }
}
