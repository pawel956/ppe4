<?php

namespace App\Service;

use App\Entity\Adresse;
use Doctrine\ORM\EntityManagerInterface;

class AdresseService
{
    protected $em;
    protected $repository;

    /**
     * AdresseService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Adresse::class);
    }

    /**
     * Save a Adresse object in bdd
     *
     * @param Adresse $adresse
     */
    public function save(Adresse $adresse)
    {
        $this->em->persist($adresse);
        $this->em->flush();
    }

    /**
     * Delete a Adresse object in bdd
     *
     * @param Adresse $adresse
     */
    public function delete(Adresse $adresse)
    {
        $this->em->remove($adresse);
        $this->em->flush();
    }
}
