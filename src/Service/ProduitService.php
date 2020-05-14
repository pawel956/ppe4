<?php

namespace App\Service;

use App\Entity\Compatible;
use App\Entity\Image;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;

class ProduitService
{
    protected $em;
    protected $repository;
    protected $compatibleService;
    protected $imageService;

    /**
     * ProduitService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     * @param CompatibleService $compatibleService
     * @param ImageService $imageService
     */
    public function __construct(EntityManagerInterface $em, CompatibleService $compatibleService, ImageService $imageService)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Produit::class);
        $this->compatibleService = $compatibleService;
        $this->imageService = $imageService;
    }

    /**
     * Save a Produit object in bdd
     *
     * @param Produit $produit
     */
    public function save(Produit $produit)
    {
        $this->em->persist($produit);
        $this->em->flush();
    }

    /**
     * Delete a Produit object in bdd
     *
     * @param Produit $produit
     */
    public function delete(Produit $produit)
    {
        $this->em->remove($produit);
        $this->em->flush();
    }

    /**
     * Delete a Produit object in bdd
     *
     * @param Produit $produit
     */
    public function deleteFull(Produit $produit)
    {
        /** @var Compatible $compatibles */
        $compatibles = $this->em->getRepository(Compatible::class)->findBy(['idProduit' => $produit]);

        foreach ($compatibles as $compatible){
            $this->compatibleService->delete($compatible);
        }

        /** @var Image $images */
        $images = $this->em->getRepository(Image::class)->findBy(['idProduit' => $produit]);

        foreach ($images as $image){
            $this->imageService->delete($image);
        }

        $this->delete($produit);
    }
}
