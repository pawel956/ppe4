<?php

namespace App\Service;

use App\Entity\Marque;
use Doctrine\ORM\EntityManagerInterface;

class MarqueService
{
    protected $em;
    protected $repository;

    /**
     * MarqueService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Marque::class);
    }

    /**
     * Save a Marque object in bdd
     *
     * @param Marque $marque
     */
    public function save(Marque $marque)
    {
        $this->em->persist($marque);
        $this->em->flush();
    }

    /**
     * Delete a Marque object in bdd
     *
     * @param Marque $marque
     */
    public function delete(Marque $marque)
    {
        $this->em->remove($marque);
        $this->em->flush();
    }
}
