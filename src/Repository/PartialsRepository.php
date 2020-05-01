<?php


namespace App\Repository;

class PartialsRepository
{
    protected $marqueRepository;
    protected $typeProduitRepository;

    public function __construct(MarqueRepository $marqueRepository, TypeProduitRepository $typeProduitRepository)
    {
        $this->marqueRepository = $marqueRepository;
        $this->typeProduitRepository = $typeProduitRepository;
    }

    public function getData()
    {
        return array(
            'marques' => $this->marqueRepository->findAll(),
            'typeProduits' => $this->typeProduitRepository->findAll()
        );
    }

}