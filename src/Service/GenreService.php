<?php

namespace App\Service;

use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;

class GenreService
{
    protected $em;
    protected $repository;

    /**
     * GenreService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Genre::class);
    }

    /**
     * Save a Genre object in bdd
     *
     * @param Genre $genre
     */
    public function save(Genre $genre)
    {
        $this->em->persist($genre);
        $this->em->flush();
    }

    /**
     * Delete a Genre object in bdd
     *
     * @param Genre $genre
     */
    public function delete(Genre $genre)
    {
        $this->em->remove($genre);
        $this->em->flush();
    }
}
