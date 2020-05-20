<?php


namespace App\Service;

use App\Entity\Constants;
use App\Repository\MarqueRepository;
use App\Repository\PlateformeRepository;
use App\Repository\TypeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartialsService extends AbstractController
{
    protected $plateformeRepository;
    protected $typeProduitRepository;
    protected $panierService;

    public function __construct(PlateformeRepository $plateformeRepository, TypeProduitRepository $typeProduitRepository, PanierService $panierService)
    {
        $this->plateformeRepository = $plateformeRepository;
        $this->typeProduitRepository = $typeProduitRepository;
        $this->panierService = $panierService;
    }

    public function getData()
    {
        $data = [
            'plateformes' => $this->plateformeRepository->findAll(),
            'typeProduits' => $this->typeProduitRepository->findAll(),
            'year' => date('Y'),
            'nom' => array_values(Constants::EMAIL)[0]
        ];

        if(!is_null($this->getUser())){
            $data['panier'] = $this->panierService->panierData($this->getUser()->getId());
        }

        return $data;
    }

}