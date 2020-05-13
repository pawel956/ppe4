<?php

namespace App\Service;

use App\Entity\Propriete;
use Doctrine\ORM\EntityManagerInterface;

class ProprieteService
{
    protected $em;
    protected $repository;

    /**
     * ProprieteService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Propriete::class);
    }

    /**
     * Save a Propriete object in bdd
     *
     * @param Propriete $propriete
     */
    public function save(Propriete $propriete)
    {
        $this->em->persist($propriete);
        $this->em->flush();
    }

    /**
     * Delete a Propriete object in bdd
     *
     * @param Propriete $propriete
     */
    public function delete(Propriete $propriete)
    {
        $this->em->remove($propriete);
        $this->em->flush();
    }
}
