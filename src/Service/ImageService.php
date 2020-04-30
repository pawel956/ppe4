<?php

namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;

class ImageService
{
    protected $em;
    protected $repository;

    /**
     * ImageService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Image::class);
    }

    /**
     * Save a Image object in bdd
     *
     * @param Image $Image
     */
    public function save(Image $Image)
    {
        $this->em->persist($Image);
        $this->em->flush();
    }

    /**
     * Delete a Image object in bdd
     *
     * @param Image $Image
     */
    public function delete(Image $Image)
    {
        $this->em->remove($Image);
        $this->em->flush();
    }
}
