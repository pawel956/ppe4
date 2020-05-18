<?php

namespace App\DataFixtures;

use App\Entity\Plateforme;
use App\Service\PlateformeService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PlateformeFixtures extends Fixture implements DependentFixtureInterface
{
    protected $plateformeService;
    protected $slugify;

    public function __construct(PlateformeService $plateformeService, SlugifyInterface $slugify)
    {
        $this->plateformeService = $plateformeService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesPlateformes = [
            [
                'idMarque' => $this->getReference('marquesony'),
                'libelle' => 'PS4',
                'couleur' => 'badge-primary'
            ],
            [
                'idMarque' => $this->getReference('marquemicrosoft'),
                'libelle' => 'Xbox One',
                'couleur' => 'badge-secondary'
            ],
            [
                'idMarque' => $this->getReference('marquesteam'),
                'libelle' => 'PC',
                'couleur' => 'badge-success'
            ]
        ];

        foreach ($lesPlateformes as $key => $unePlateforme) {
            $plateforme = new Plateforme();
            $plateforme->setIdMarque($unePlateforme['idMarque']);
            $plateforme->setLibelle($unePlateforme['libelle']);
            $plateforme->setCouleur($unePlateforme['couleur']);
            $this->plateformeService->save($plateforme);

            $this->addReference('plateforme' . $this->slugify->slugify($plateforme->getLibelle()), $plateforme);
        }
    }

    public function getDependencies()
    {
        return array(
            MarqueFixtures::class
        );
    }
}
