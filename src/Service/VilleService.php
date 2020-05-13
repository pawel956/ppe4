<?php

namespace App\Service;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;

class VilleService
{
    protected $em;
    protected $repository;

    /**
     * VilleService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Ville::class);
    }

    /**
     * Save a Ville object in bdd
     *
     * @param Ville $ville
     */
    public function save(Ville $ville)
    {
        $this->em->persist($ville);
        $this->em->flush();
    }

    /**
     * Delete a Ville object in bdd
     *
     * @param Ville $ville
     */
    public function delete(Ville $ville)
    {
        $this->em->remove($ville);
        $this->em->flush();
    }
}
