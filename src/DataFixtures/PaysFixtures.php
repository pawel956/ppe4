<?php

namespace App\DataFixtures;

use App\Entity\Pays;
use App\Service\PaysService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaysFixtures extends Fixture
{
    protected $paysService;
    protected $slugify;

    public function __construct(PaysService $paysService, SlugifyInterface $slugify)
    {
        $this->paysService = $paysService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesPays = [
            [
                'libelle' => 'FR'
            ]
        ];

        foreach ($lesPays as $unPays) {
            $pays = new Pays();
            $pays->setLibelle($unPays['libelle']);
            $this->paysService->save($pays);

            $this->addReference('pays' . $this->slugify->slugify($pays->getLibelle()), $pays);
        }
    }
}
