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
        $lesImage = ['110'];

        foreach ($lesImage as $key => $uneImage) {
            $image = new Image();
            $image->setIdTypeImage($this->getReference('typeImage'));
            $image->setIdProduit($this->getReference('produit'));
            $image->setLibelle($uneImage);
            $this->imageService->save($image);
        }
    }

    public function getDependencies()
    {
        return array(
            TypeImageFixtures::class,
            ProduitFixtures::class,
        );
    }
}
