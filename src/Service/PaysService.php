<?php

namespace App\Service;

use App\Entity\Pays;
use Doctrine\ORM\EntityManagerInterface;

class PaysService
{
    protected $em;
    protected $repository;

    /**
     * PaysService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Pays::class);
    }

    /**
     * Save a Pays object in bdd
     *
     * @param Pays $pays
     */
    public function save(Pays $pays)
    {
        $this->em->persist($pays);
        $this->em->flush();
    }

    /**
     * Delete a Pays object in bdd
     *
     * @param Pays $pays
     */
    public function delete(Pays $pays)
    {
        $this->em->remove($pays);
        $this->em->flush();
    }
}
