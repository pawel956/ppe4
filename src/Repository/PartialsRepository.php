<?php


namespace App\Repository;

use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartialsRepository extends AbstractController
{
    protected $marqueRepository;
    protected $typeProduitRepository;
    protected $panierService;

    public function __construct(MarqueRepository $marqueRepository, TypeProduitRepository $typeProduitRepository, PanierService $panierService)
    {
        $this->marqueRepository = $marqueRepository;
        $this->typeProduitRepository = $typeProduitRepository;
        $this->panierService = $panierService;
    }

    public function getData()
    {
        return array(
            'marques' => $this->marqueRepository->findAll(),
            'typeProduits' => $this->typeProduitRepository->findAll(),
            'year' => date('Y'),
            'panier' => $this->panierService->panierData($this->getUser()->getId())
        );
    }

}