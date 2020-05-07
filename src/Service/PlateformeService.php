<?php

namespace App\Service;

use App\Entity\Plateforme;
use Doctrine\ORM\EntityManagerInterface;

class PlateformeService
{
    protected $em;
    protected $repository;

    /**
     * PlateformeService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Plateforme::class);
    }

    /**
     * Save a Plateforme object in bdd
     *
     * @param Plateforme $plateforme
     */
    public function save(Plateforme $plateforme)
    {
        $this->em->persist($plateforme);
        $this->em->flush();
    }

    /**
     * Delete a Plateforme object in bdd
     *
     * @param Plateforme $plateforme
     */
    public function delete(Plateforme $plateforme)
    {
        $this->em->remove($plateforme);
        $this->em->flush();
    }
}
