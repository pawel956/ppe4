<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Service\ImageService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesImages = [
            [
                'idTypeImage' => $this->getReference('typeImagepng'),
                'idProduit' => $this->getReference('produitps4'),
                'libelle' => 'ps4'
            ],
            [
                'idTypeImage' => $this->getReference('typeImagepng'),
                'idProduit' => $this->getReference('produitxbox-one-s'),
                'libelle' => 'xboxone'
            ],
            [
                'idTypeImage' => $this->getReference('typeImagejpg'),
                'idProduit' => $this->getReference('produitred-dead-redemption-2'),
                'libelle' => 'reddeadredemption2'
            ],
            [
                'idTypeImage' => $this->getReference('typeImagejpg'),
                'idProduit' => $this->getReference('produitgrand-theft-auto-v'),
                'libelle' => 'gtav'
            ],
            [
                'idTypeImage' => $this->getReference('typeImagejpg'),
                'idProduit' => $this->getReference('produitforza-horizon-4'),
                'libelle' => 'forza'
            ],
            [
                'idTypeImage' => $this->getReference('typeImagejpg'),
                'idProduit' => $this->getReference('produituncharted-4-a-thief-s-end'),
                'libelle' => 'uncharted4'
            ],
        ];

        foreach ($lesImages as $key => $uneImage) {
            $image = new Image();
            $image->setIdTypeImage($uneImage['idTypeImage']);
            $image->setIdProduit($uneImage['idProduit']);
            $image->setLibelle($uneImage['libelle']);
            $this->imageService->save($image);
        }
    }

    public function getDependencies()
    {
        return array(
            TypeImageFixtures::class,
            ProduitFixtures::class
        );
    }
}
