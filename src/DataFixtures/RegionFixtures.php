<?php

namespace App\DataFixtures;

use App\Entity\Region;
use App\Service\RegionService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture implements DependentFixtureInterface
{
    protected $regionService;
    protected $slugify;

    public function __construct(RegionService $regionService, SlugifyInterface $slugify)
    {
        $this->regionService = $regionService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesRegions = [
            [
                'libelle' => 'Occitanie',
                'idPays' => $this->getReference('paysfr')
            ],
            [
                'libelle' => 'Île-de-France',
                'idPays' => $this->getReference('paysfr')
            ]
        ];

        foreach ($lesRegions as $uneRegion) {
            $region = new Region();
            $region->setLibelle($uneRegion['libelle']);
            $region->setIdPays($uneRegion['idPays']);
            $this->regionService->save($region);

            $this->addReference('region' . $this->slugify->slugify($region->getLibelle()), $region);
        }
    }

    public function getDependencies()
    {
        return array(
            PaysFixtures::class
        );
    }
}
