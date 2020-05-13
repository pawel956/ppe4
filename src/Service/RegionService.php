<?php

namespace App\Service;

use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;

class RegionService
{
    protected $em;
    protected $repository;

    /**
     * RegionService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Region::class);
    }

    /**
     * Save a Region object in bdd
     *
     * @param Region $region
     */
    public function save(Region $region)
    {
        $this->em->persist($region);
        $this->em->flush();
    }

    /**
     * Delete a Region object in bdd
     *
     * @param Region $region
     */
    public function delete(Region $region)
    {
        $this->em->remove($region);
        $this->em->flush();
    }
}
