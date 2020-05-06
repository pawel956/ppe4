<?php

namespace App\Controller;

use App\Repository\PartialsRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PartialsRepository $partialsRepository
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function index(PartialsRepository $partialsRepository, ProduitRepository $produitRepository)
    {
        $data = $produitRepository->findLastFourProducts();

        return $this->render('index/index.html.twig', [
            'partials' => $partialsRepository->getData(),
            'produits' => $data['produits'],
            'images' => $data['images']
        ]);
    }
}
