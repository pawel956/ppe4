<?php

namespace App\Service;

use App\Entity\TypeImage;
use Doctrine\ORM\EntityManagerInterface;

class TypeImageService
{
    protected $em;
    protected $repository;

    /**
     * TypeImageService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(TypeImage::class);
    }

    /**
     * Save a TypeImage object in bdd
     *
     * @param TypeImage $typeImage
     */
    public function save(TypeImage $typeImage)
    {
        $this->em->persist($typeImage);
        $this->em->flush();
    }

    /**
     * Delete a TypeImage object in bdd
     *
     * @param TypeImage $typeImage
     */
    public function delete(TypeImage $typeImage)
    {
        $this->em->remove($typeImage);
        $this->em->flush();
    }
}
