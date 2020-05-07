<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Service\MarqueService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
    protected $marqueService;
    protected $slugify;

    public function __construct(MarqueService $marqueService, SlugifyInterface $slugify)
    {
        $this->marqueService = $marqueService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesMarque = ['Sony', 'Microsoft', 'Nintendo', 'Steam', 'Rockstar Games', 'Playground Games', 'Naughty Dog'];

        foreach ($lesMarque as $key => $uneMarque) {
            $marque = new Marque();
            $marque->setLibelle($uneMarque);
            if ($key == 0 || $key == 1 || $key == 2 || $key == 3) {
                $marque->setConstructeur(true);
            }
            $this->marqueService->save($marque);

            $this->addReference('marque' . $this->slugify->slugify($marque->getLibelle()), $marque);
        }
    }
}
