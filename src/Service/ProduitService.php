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
     * @param Produit $Produit
     */
    public function save(Produit $Produit)
    {
        $this->em->persist($Produit);
        $this->em->flush();
    }

    /**
     * Delete a Produit object in bdd
     *
     * @param Produit $Produit
     */
    public function delete(Produit $Produit)
    {
        $this->em->remove($Produit);
        $this->em->flush();
    }
}
