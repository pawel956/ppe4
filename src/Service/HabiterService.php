<?php

namespace App\Service;

use App\Entity\Habiter;
use Doctrine\ORM\EntityManagerInterface;

class HabiterService
{
    protected $em;
    protected $repository;

    /**
     * HabiterService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Habiter::class);
    }

    /**
     * Save a Habiter object in bdd
     *
     * @param Habiter $habiter
     */
    public function save(Habiter $habiter)
    {
        $this->em->persist($habiter);
        $this->em->flush();
    }

    /**
     * Delete a Habiter object in bdd
     *
     * @param Habiter $habiter
     */
    public function delete(Habiter $habiter)
    {
        $this->em->remove($habiter);
        $this->em->flush();
    }
}
