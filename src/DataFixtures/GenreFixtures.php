<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Service\GenreService;
use Cocur\Slugify\SlugifyInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    protected $genreService;
    protected $slugify;

    public function __construct(GenreService $genreService, SlugifyInterface $slugify)
    {
        $this->genreService = $genreService;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesGenre = [
            [
                'libelle' => 'Homme'
            ],
            [
                'libelle' => 'Femme'
            ]
        ];

        foreach ($lesGenre as $unGenre) {
            $genre = new Genre();
            $genre->setLibelle($unGenre['libelle']);
            $this->genreService->save($genre);

            $this->addReference('genre' . $this->slugify->slugify($genre->getLibelle()), $genre);
        }
    }
}
