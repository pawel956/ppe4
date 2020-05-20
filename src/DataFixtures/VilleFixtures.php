<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use App\Service\VilleService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture implements DependentFixtureInterface
{
    protected $villeService;
    protected $slugify;

    public function __construct(VilleService $villeService, SlugifyInterface $slugify)
    {
        $this->villeService = $villeService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesVilles = [
            [
                'codePostal' => '34300',
                'libelle' => 'Agde',
                'idRegion' => $this->getReference('regionoccitanie')
            ],
            [
                'codePostal' => '75008',
                'libelle' => 'Paris (8e arrondissement)',
                'idRegion' => $this->getReference('regionile-de-france')
            ]
        ];

        foreach ($lesVilles as $uneVille) {
            $ville = new Ville();
            $ville->setCodePostal($uneVille['codePostal']);
            $ville->setLibelle($uneVille['libelle']);
            $ville->setIdRegion($uneVille['idRegion']);
            $this->villeService->save($ville);

            $this->addReference('ville' . $this->slugify->slugify($ville->getLibelle()), $ville);
        }
    }

    public function getDependencies()
    {
        return array(
            RegionFixtures::class
        );
    }
}
