<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Service\ProduitService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    protected $produitService;
    protected $slugify;

    public function __construct(ProduitService $produitService, SlugifyInterface $slugify)
    {
        $this->produitService = $produitService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesProduits = [
            [
                'idTypeProduit' => $this->getReference('typeProduitConsoles'),
                'idMarque' => $this->getReference('marquesony'),
                'libelle' => 'PS4',
                'description' => 'La nouvelle console next-gen de Sony !',
                'prix' => '399.99',
                'prixTemporaire' => '199.99',
            ],
            [
                'idTypeProduit' => $this->getReference('typeProduitConsoles'),
                'idMarque' => $this->getReference('marquemicrosoft'),
                'libelle' => 'Xbox One S',
                'description' => 'La nouvelle console next-gen de Microsoft !',
                'prix' => '399.99',
            ],
            [
                'idTypeProduit' => $this->getReference('typeProduitJeux'),
                'idMarque' => $this->getReference('marquerockstar-games'),
                'libelle' => 'Red Dead Redemption 2',
                'description' => 'Le dernier jeu de la licence Red Dead Redemption !',
                'prix' => '69.99',
            ],
            [
                'idTypeProduit' => $this->getReference('typeProduitJeux'),
                'idMarque' => $this->getReference('marquerockstar-games'),
                'libelle' => 'Grand Theft Auto V',
                'description' => 'Le nouveau open-world Grand Theft Auto',
                'prix' => '69.99',
                'prixTemporaire' => '12.99',
            ],
            [
                'idTypeProduit' => $this->getReference('typeProduitJeux'),
                'idMarque' => $this->getReference('marqueplayground-games'),
                'libelle' => 'Forza Horizon 4',
                'description' => 'Le dernier jeu de la licence Forza Horizon !',
                'prix' => '69.99',
                'prixTemporaire' => '34.99',
            ],
            [
                'idTypeProduit' => $this->getReference('typeProduitJeux'),
                'idMarque' => $this->getReference('marquenaughty-dog'),
                'libelle' => 'Uncharted 4: A Thief\'s End',
                'description' => 'Le nouveau jeu d\'action aventure de la franchise Uncharted',
                'prix' => '69.99',
            ]
        ];

        foreach ($lesProduits as $key => $unProduit) {
            $produit = new Produit();
            $produit->setIdTypeProduit($unProduit['idTypeProduit']);
            $produit->setIdMarque($unProduit['idMarque']);
            $produit->setLibelle($unProduit['libelle']);
            $produit->setDescription($unProduit['description']);
            $produit->setPrix($unProduit['prix']);
            if (isset($unProduit['prixTemporaire'])) {
                $produit->setPrixTemporaire($unProduit['prixTemporaire']);
            }
            $this->produitService->save($produit);

            $this->addReference('produit' . $this->slugify->slugify($produit->getLibelle()), $produit);
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
