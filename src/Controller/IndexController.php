<?php

namespace App\Controller;

use App\Entity\Constants;
use App\Service\PartialsService;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PartialsService $partialsService
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function index(PartialsService $partialsService, ProduitRepository $produitRepository)
    {
        $data = $produitRepository->findLastFourProducts();

        return $this->render('index/index.html.twig', [
            'partials' => $partialsService->getData(),
            'produits' => $data['produits'],
            'images' => $data['images'],
            'produitPicturesDirectory' => Constants::PRODUCT_PICTURES_DIRECTORY_TWIG
        ]);
    }
}
