<?php

namespace App\DataFixtures;

use App\Entity\Compatible;
use App\Service\CompatibleService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CompatibleFixtures extends Fixture implements DependentFixtureInterface
{
    protected $compatibleService;

    public function __construct(CompatibleService $compatibleService)
    {
        $this->compatibleService = $compatibleService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesCompatibles = [
            [
                'idProduit' => $this->getReference('produitps4'),
                'idPlateforme' => $this->getReference('plateformeps4')
            ],
            [
                'idProduit' => $this->getReference('produitxbox-one-s'),
                'idPlateforme' => $this->getReference('plateformexbox-one')
            ],
            [
                'idProduit' => $this->getReference('produitred-dead-redemption-2'),
                'idPlateforme' => $this->getReference('plateformeps4')
            ],
            [
                'idProduit' => $this->getReference('produitred-dead-redemption-2'),
                'idPlateforme' => $this->getReference('plateformexbox-one')
            ],
            [
                'idProduit' => $this->getReference('produitred-dead-redemption-2'),
                'idPlateforme' => $this->getReference('plateformepc')
            ],
            [
                'idProduit' => $this->getReference('produitgrand-theft-auto-v'),
                'idPlateforme' => $this->getReference('plateformeps4')
            ],
            [
                'idProduit' => $this->getReference('produitgrand-theft-auto-v'),
                'idPlateforme' => $this->getReference('plateformexbox-one')
            ],
            [
                'idProduit' => $this->getReference('produitgrand-theft-auto-v'),
                'idPlateforme' => $this->getReference('plateformepc')
            ],
            [
                'idProduit' => $this->getReference('produitforza-horizon-4'),
                'idPlateforme' => $this->getReference('plateformexbox-one')
            ],
            [
                'idProduit' => $this->getReference('produituncharted-4-a-thief-s-end'),
                'idPlateforme' => $this->getReference('plateformeps4')
            ],
        ];

        foreach ($lesCompatibles as $key => $unCompatible) {
            $compatible = new Compatible();
            $compatible->setIdProduit($unCompatible['idProduit']);
            $compatible->setIdPlateforme($unCompatible['idPlateforme']);
            $this->compatibleService->save($compatible);
        }
    }

    public function getDependencies()
    {
        return array(
            ProduitFixtures::class,
            PlateformeFixtures::class
        );
    }
}
