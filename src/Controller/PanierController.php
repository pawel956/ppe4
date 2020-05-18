<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Constants;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use App\Service\PartialsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param ProduitRepository $produitRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository, PanierRepository $panierRepository, ProduitRepository $produitRepository, PartialsService $partialsService)
    {
        /** @var Commande $commande */
        $commande = $commandeRepository->findOneBy(['idUtilisateur' => $this->getUser(), 'dateCommande' => null]);

        if ($commande == null) {
            return $this->redirectToRoute('index');
        }

        $panier = $panierRepository->findBy(['idCommande' => $commande]);

        if ($panier == null) {
            return $this->redirectToRoute('index');
        }

        return $this->render('panier/index.html.twig', [
            'partials' => $partialsService->getData(),
            'panier' => $panier,
            'images' => $produitRepository->findProductsPictures($panier),
            'qtePanier' => $panierRepository->numberProducts($commande),
            'totalPanier' => $panierRepository->totalPanier($commande),
            'productPicturesDirectory' => Constants::PRODUCT_PICTURES_DIRECTORY_TWIG
        ]);
    }

    /**
     * @Route("/paiement", name="paiement")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function paiement(CommandeRepository $commandeRepository, PanierRepository $panierRepository, PartialsService $partialsService)
    {
        /** @var Commande $commande */
        $commande = $commandeRepository->findOneBy(['idUtilisateur' => $this->getUser(), 'dateCommande' => null]);

        if ($commande == null) {
            return $this->redirectToRoute('index');
        }

        return $this->render('panier/paiement.html.twig', [
            'partials' => $partialsService->getData(),
            'totalPanier' => $panierRepository->totalPanier($commande),
            'paypalClientId' => Constants::PAYPAL_CLIENT_ID
        ]);
    }
}
