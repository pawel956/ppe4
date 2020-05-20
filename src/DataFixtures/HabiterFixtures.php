<?php

namespace App\DataFixtures;

use App\Entity\Habiter;
use App\Service\HabiterService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HabiterFixtures extends Fixture implements DependentFixtureInterface
{
    protected $habiterService;

    public function __construct(HabiterService $habiterService)
    {
        $this->habiterService = $habiterService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesHabiters = [
            [
                'idUtilisateur' => $this->getReference('utilisateuradminatgmail-com'),
                'idPropriete' => $this->getReference('propriete11')
            ],
            [
                'idUtilisateur' => $this->getReference('utilisateuruseratgmail-com'),
                'idPropriete' => $this->getReference('propriete54')
            ]
        ];

        foreach ($lesHabiters as $unHabiter) {
            $habiter = new Habiter();
            $habiter->setIdUtilisateur($unHabiter['idUtilisateur']);
            $habiter->setIdPropriete($unHabiter['idPropriete']);
            $this->habiterService->save($habiter);
        }
    }

    public function getDependencies()
    {
        return array(
            UtilisateurFixtures::class,
            ProprieteFixtures::class
        );
    }
}
