<?php

namespace App\Service;

use App\Entity\Compatible;
use Doctrine\ORM\EntityManagerInterface;

class CompatibleService
{
    protected $em;
    protected $repository;

    /**
     * CompatibleService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Compatible::class);
    }

    /**
     * Save a Compatible object in bdd
     *
     * @param Compatible $compatible
     */
    public function save(Compatible $compatible)
    {
        $this->em->persist($compatible);
        $this->em->flush();
    }

    /**
     * Delete a Compatible object in bdd
     *
     * @param Compatible $compatible
     */
    public function delete(Compatible $compatible)
    {
        $this->em->remove($compatible);
        $this->em->flush();
    }
}
