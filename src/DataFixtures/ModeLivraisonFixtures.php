<?php

namespace App\DataFixtures;

use App\Entity\ModeLivraison;
use App\Service\ModeLivraisonService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ModeLivraisonFixtures extends Fixture
{
    protected $modeLivraisonService;

    public function __construct(ModeLivraisonService $modeLivraisonService)
    {
        $this->modeLivraisonService = $modeLivraisonService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesModeLivraison = [
            [
                'libelle' => 'Colissimo',
                'prix' => '7.50',
                'delai' => '3'
            ],
            [
                'libelle' => 'Chronopost',
                'prix' => '23.00',
                'delai' => '1'
            ],
            [
                'libelle' => 'Relais Colis',
                'prix' => '5.00',
                'delai' => '5'
            ]
        ];

        foreach ($lesModeLivraison as $unModeLivraison) {
            $modeLivraison = new ModeLivraison();
            $modeLivraison->setLibelle($unModeLivraison['libelle']);
            $modeLivraison->setPrix($unModeLivraison['prix']);
            $modeLivraison->setDelai($unModeLivraison['delai']);
            $this->modeLivraisonService->save($modeLivraison);
        }
    }
}
