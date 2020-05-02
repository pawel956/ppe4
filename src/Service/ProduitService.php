<?php

namespace App\Service;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;

class ProduitService
{
    protected $em;
    protected $repository;

    /**
     * ProduitService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Produit::class);
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
}
