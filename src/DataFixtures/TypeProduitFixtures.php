<?php

namespace App\DataFixtures;

use App\Entity\TypeProduit;
use App\Service\TypeProduitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeProduitFixtures extends Fixture
{
    protected $typeProduitService;

    public function __construct(TypeProduitService $typeProduitService)
    {
        $this->typeProduitService = $typeProduitService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesTypeProduit = ['Jeux', 'Consoles', 'Accessoires', 'Cartes prépayées'];

        foreach ($lesTypeProduit as $key => $unTypeProduit) {
            $typeProduit = new TypeProduit();
            $typeProduit->setLibelle($unTypeProduit);
            $this->typeProduitService->save($typeProduit);

            if ($key == 0 || $key == 1) {
                $this->addReference('typeProduit' . $typeProduit->getLibelle(), $typeProduit);
            }
        }
    }
}
