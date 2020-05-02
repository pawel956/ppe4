<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Service\ProduitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    protected $produitService;

    public function __construct(ProduitService $produitService)
    {
        $this->produitService = $produitService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesProduit = ['PS4'];

        foreach ($lesProduit as $key => $unProduit) {
            $produit = new Produit();
            $produit->setIdTypeProduit($this->getReference('typeProduit'));
            $produit->setIdMarque($this->getReference('marque'));
            $produit->setLibelle($unProduit);
            $produit->setDescription('La nouvelle console next-gen de Sony !');
            $produit->setPrix('40');
            $produit->setPrixTemporaire('30');
            $this->produitService->save($produit);

            if ($key == 0) {
                $this->addReference('produit', $produit);
            }
        }
    }

    public function getDependencies()
    {
        return array(
            TypeProduitFixtures::class,
            MarqueFixtures::class
        );
    }
}
