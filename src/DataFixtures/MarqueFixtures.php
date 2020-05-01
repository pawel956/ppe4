<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Service\MarqueService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
    protected $marqueService;

    public function __construct(MarqueService $marqueService)
    {
        $this->marqueService = $marqueService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesMarque = ['Sony', 'Microsoft', 'Nintendo', 'Steam'];

        foreach ($lesMarque as $key => $uneMarque) {
            $marque = new Marque();
            $marque->setLibelle($uneMarque);
            $this->marqueService->save($marque);

            if ($key == 0) {
                $this->addReference('marque', $marque);
            }
        }
    }
}
