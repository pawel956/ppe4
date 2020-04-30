<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Produit;
use App\Entity\TypeImage;
use App\Service\ImageService;
use App\Service\ProduitService;
use App\Service\TypeImageService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    protected $produitService;
    protected $imageService;
    protected $typeImageService;

    public function __construct(ProduitService $produitService, ImageService $imageService, TypeImageService $typeImageService)
    {
        $this->produitService = $produitService;
        $this->imageService = $imageService;
        $this->typeImageService = $typeImageService;
    }

    public function load(ObjectManager $entityManager)
    {
        $TypeImage = new TypeImage();
        $TypeImage->setLibelle('png');
        $this->typeImageService->save($TypeImage);

        $Produit = new Produit();
        $Produit->setLibelle('PS4');
        $Produit->setPrix('40');
        $Produit->setPrixTemporaire('30');
        $this->produitService->save($Produit);

        $Image = new Image();
        $Image->setLibelle('110');
        $Image->setIdTypeImage($TypeImage);
        $Image->setIdProduit($Produit);
        $this->imageService->save($Image);
    }
}
