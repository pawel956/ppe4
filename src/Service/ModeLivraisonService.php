<?php

namespace App\Service;

use App\Entity\ModeLivraison;
use Doctrine\ORM\EntityManagerInterface;

class ModeLivraisonService
{
    protected $em;
    protected $repository;

    /**
     * ModeLivraisonService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(ModeLivraison::class);
    }

    /**
     * Save a ModeLivraison object in bdd
     *
     * @param ModeLivraison $modeLivraison
     */
    public function save(ModeLivraison $modeLivraison)
    {
        $this->em->persist($modeLivraison);
        $this->em->flush();
    }

    /**
     * Delete a ModeLivraison object in bdd
     *
     * @param ModeLivraison $modeLivraison
     */
    public function delete(ModeLivraison $modeLivraison)
    {
        $this->em->remove($modeLivraison);
        $this->em->flush();
    }
}
