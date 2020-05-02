<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Service\GenreService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesGenre = ['Homme', 'Femme'];

        foreach ($lesGenre as $key => $unGenre) {
            $genre = new Genre();
            $genre->setLibelle($unGenre);
            $this->genreService->save($genre);

            if ($key == 0) {
                $this->addReference('genre', $genre);
            }
        }
    }
}
