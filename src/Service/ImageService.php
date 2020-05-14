<?php

namespace App\Service;

use App\Entity\Constants;
use App\Entity\Image;
use App\Entity\TypeImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\KernelInterface;

class ImageService
{
    protected $em;
    protected $repository;
    private $appKernel;
    protected $typeImageService;

    /**
     * ImageService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     * @param KernelInterface $appKernel
     * @param TypeImageService $typeImageService
     */
    public function __construct(EntityManagerInterface $em, KernelInterface $appKernel, TypeImageService $typeImageService)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Image::class);
        $this->appKernel = $appKernel;
        $this->typeImageService = $typeImageService;
    }

    /**
     * Save a Image object in bdd
     *
     * @param Image $image
     */
    public function save(Image $image)
    {
        $this->em->persist($image);
        $this->em->flush();
    }

    /**
     * Delete a Image object in bdd
     *
     * @param Image $image
     */
    public function delete(Image $image)
    {
        $this->em->remove($image);
        $this->em->flush();
    }

    /**
     * @param File $file
     * @return Image
     */
    public function upload(File $file)
    {
        $fileExtension = $file->guessExtension();
        $newFilename = uniqid(rand() . '_');
        $newFilenameExtension = $newFilename . '.' . $fileExtension;

        // Move the file to the directory
        try {
            $file->move($this->appKernel->getProjectDir() . Constants::PROFILE_PICTURES_DIRECTORY, $newFilenameExtension);
        } catch (FileException $ex) {
            die;
        }

        $typeImage = $this->em->getRepository(TypeImage::class)->findOneBy(['libelle' => $fileExtension]);

        if ($typeImage == null) {
            $typeImage = new TypeImage();
            $typeImage->setLibelle($fileExtension);
            $this->typeImageService->save($typeImage);
        }

        $image = new Image();
        $image->setIdTypeImage($typeImage);
        $image->setLibelle($newFilename);
        $this->save($image);

        return $image;
    }
}
