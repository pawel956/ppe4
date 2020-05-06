<?php

namespace App\Service;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;

class CommandeService
{
    protected $em;
    protected $repository;

    /**
     * CommandeService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Commande::class);
    }

    /**
     * Save a Commande object in bdd
     *
     * @param Commande $commande
     */
    public function save(Commande $commande)
    {
        $this->em->persist($commande);
        $this->em->flush();
    }

    /**
     * Delete a Commande object in bdd
     *
     * @param Commande $commande
     */
    public function delete(Commande $commande)
    {
        $this->em->remove($commande);
        $this->em->flush();
    }
}
