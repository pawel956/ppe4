<?php

namespace App\DataFixtures;

use App\Entity\TypeImage;
use App\Service\TypeImageService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeImageFixtures extends Fixture
{
    protected $typeImageService;

    public function __construct(TypeImageService $typeImageService)
    {
        $this->typeImageService = $typeImageService;
    }

    public function load(ObjectManager $entityManager)
    {
        $lesTypeImage = ['png', 'jpg'];

        foreach ($lesTypeImage as $key => $unTypeImage) {
            $typeImage = new TypeImage();
            $typeImage->setLibelle($unTypeImage);
            $this->typeImageService->save($typeImage);

            $this->addReference('typeImage' . $typeImage->getLibelle(), $typeImage);
        }
    }
}
