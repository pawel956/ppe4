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
     * @param Marque $Marque
     */
    public function save(Marque $Marque)
    {
        $this->em->persist($Marque);
        $this->em->flush();
    }

    /**
     * Delete a Marque object in bdd
     *
     * @param Marque $Marque
     */
    public function delete(Marque $Marque)
    {
        $this->em->remove($Marque);
        $this->em->flush();
    }
}
