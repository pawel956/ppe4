<?php

namespace App\Service;

use App\Entity\TypeProduit;
use Doctrine\ORM\EntityManagerInterface;

class TypeProduitService
{
    protected $em;
    protected $repository;

    /**
     * TypeProduitService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(TypeProduit::class);
    }

    /**
     * Save a TypeProduit object in bdd
     *
     * @param TypeProduit $typeProduit
     */
    public function save(TypeProduit $typeProduit)
    {
        $this->em->persist($typeProduit);
        $this->em->flush();
    }

    /**
     * Delete a TypeProduit object in bdd
     *
     * @param TypeProduit $typeProduit
     */
    public function delete(TypeProduit $typeProduit)
    {
        $this->em->remove($typeProduit);
        $this->em->flush();
    }
}
