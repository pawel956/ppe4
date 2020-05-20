<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Constants;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
use App\Repository\PanierRepository;
use App\Service\PartialsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mes_commandes", name="mes_commandes_")
 */
class MesCommandesController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository, PanierRepository $panierRepository, PartialsService $partialsService)
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $commandes = $commandeRepository->findAllCommandes($utilisateur);

        $totauxCommandes = null;
        foreach ($commandes as $commande) {
            /** @var Commande $commande */
            $totauxCommandes[$commande->getId()] = $panierRepository->totalPanier($commande) + $commande->getIdModeLivraison()->getPrix();
        }

        return $this->render('commande/index.html.twig', [
            'partials' => $partialsService->getData(),
            'commandes' => $commandes,
            'totauxCommandes' => $totauxCommandes
        ]);
    }

    /**
     * @Route("/voir_pdf/{id}", name="voir_pdf", methods={"GET"})
     * @param KernelInterface $appKernel
     * @param Commande $commande
     * @return BinaryFileResponse
     */
    public function voirPdf(KernelInterface $appKernel, Commande $commande)
    {
        return new BinaryFileResponse($appKernel->getProjectDir() . Constants::FACTURE_FILE_DIRECTORY . '/' . $commande->getFacturePdf() . '.pdf');
    }
}
