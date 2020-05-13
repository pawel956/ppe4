<?php

namespace App\Controller;

use App\Service\PartialsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(PartialsService $partialsService)
    {
        return $this->render('panier/index.html.twig', [
            'partials' => $partialsService->getData()
        ]);
    }
}
