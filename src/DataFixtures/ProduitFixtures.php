<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Marque;
use App\Entity\Produit;
use App\Entity\TypeImage;
use App\Entity\TypeProduit;
use App\Service\ImageService;
use App\Service\MarqueService;
use App\Service\ProduitService;
use App\Service\TypeImageService;
use App\Service\TypeProduitService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    protected $typeProduitService;
    protected $marqueService;
    protected $typeImageService;
    protected $produitService;
    protected $imageService;

    public function __construct(TypeProduitService $typeProduitService, MarqueService $marqueService, TypeImageService $typeImageService, ProduitService $produitService, ImageService $imageService)
    {
        $this->typeProduitService = $typeProduitService;
        $this->marqueService = $marqueService;
        $this->typeImageService = $typeImageService;
        $this->produitService = $produitService;
        $this->imageService = $imageService;
    }

    public function load(ObjectManager $entityManager)
    {
        $TypeProduit = new TypeProduit();
        $TypeProduit->setLibelle('Console');
        $this->typeProduitService->save($TypeProduit);

        $Marque = new Marque();
        $Marque->setLibelle('Sony');
        $this->marqueService->save($Marque);

        $TypeImage = new TypeImage();
        $TypeImage->setLibelle('png');
        $this->typeImageService->save($TypeImage);

        $Produit = new Produit();
        $Produit->setIdTypeProduit($TypeProduit);
        $Produit->setIdMarque($Marque);
        $Produit->setLibelle('PS4');
        $Produit->setDescription('La nouvelle console next-gen de Sony !');
        $Produit->setPrix('40');
        $Produit->setPrixTemporaire('30');
        $this->produitService->save($Produit);

        $Image = new Image();
        $Image->setIdTypeImage($TypeImage);
        $Image->setIdProduit($Produit);
        $Image->setLibelle('110');
        $this->imageService->save($Image);
    }
}
