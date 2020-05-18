<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Constants;
use App\Repository\CommandeRepository;
use App\Repository\HabiterRepository;
use App\Repository\ModeLivraisonRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\ProprieteRepository;
use App\Service\CommandeService;
use App\Service\HabiterService;
use App\Service\PartialsService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier", name="panier_")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param ProduitRepository $produitRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository, PanierRepository $panierRepository, ProduitRepository $produitRepository, PartialsService $partialsService)
    {
        $data = $this->getMainData($commandeRepository, $panierRepository);

        return $this->render('panier/index.html.twig', [
            'partials' => $partialsService->getData(),
            'panier' => $data['panier'],
            'images' => $produitRepository->findProductsPictures($data['panier']),
            'qtePanier' => $panierRepository->numberProducts($data['commande']),
            'totalPanier' => $panierRepository->totalPanier($data['commande']),
            'productPicturesDirectory' => Constants::PRODUCT_PICTURES_DIRECTORY_TWIG
        ]);
    }

    /**
     * @Route("/mode_livraison", name="mode_livraison")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param ProduitRepository $produitRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function modeLivraison(CommandeRepository $commandeRepository, PanierRepository $panierRepository, ModeLivraisonRepository $modeLivraisonRepository, ProduitRepository $produitRepository, PartialsService $partialsService)
    {
        $data = $this->getMainData($commandeRepository, $panierRepository);

        return $this->render('panier/mode_livraison.html.twig', [
            'partials' => $partialsService->getData(),
            'panier' => $data['panier'],
            'images' => $produitRepository->findProductsPictures($data['panier']),
            'qtePanier' => $panierRepository->numberProducts($data['commande']),
            'totalPanier' => $panierRepository->totalPanier($data['commande']),
            'modes_livraison' => $modeLivraisonRepository->findAll(),
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
        $data = $this->getMainData($commandeRepository, $panierRepository);

        return $this->render('panier/paiement.html.twig', [
            'partials' => $partialsService->getData(),
            'totalPanier' => $panierRepository->totalPanier($data['commande']),
            'paypalClientId' => Constants::PAYPAL_CLIENT_ID
        ]);
    }

    /**
     * @Route("/paiement_success", name="paiement_success")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param HabiterRepository $habiterRepository
     * @param ProprieteRepository $proprieteRepository
     * @param CommandeService $commandeService
     * @param PartialsService $partialsService
     * @return Response
     */
    public function paymentSuccess(CommandeRepository $commandeRepository, PanierRepository $panierRepository, HabiterRepository $habiterRepository, ProprieteRepository $proprieteRepository, CommandeService $commandeService, PartialsService $partialsService)
    {
        $data = $this->getMainData($commandeRepository, $panierRepository);

        $habiter = $habiterRepository->findOneBy(['idUtilisateur' => $this->getUser(), 'defaut' => true]);
        $propriete = $proprieteRepository->findOneBy(['id' => $habiter->getIdPropriete()]);

        $data['commande']->setIdPropriete($propriete);
        $data['commande']->setDateCommande(new DateTime());
        $commandeService->save($data['commande']);

        return $this->render('panier/paiement_success.html.twig', [
            'partials' => $partialsService->getData()
        ]);
    }

    /**
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @return array|RedirectResponse
     */
    public function getMainData(CommandeRepository $commandeRepository, PanierRepository $panierRepository)
    {
        $commande = $commandeRepository->findOneBy(['idUtilisateur' => $this->getUser(), 'dateCommande' => null]);

        if (!$commande) {
            return $this->redirectToRoute('index');
        }

        $panier = $panierRepository->findBy(['idCommande' => $commande]);

        if (!$panier) {
            return $this->redirectToRoute('index');
        }

        return [
            'commande' => $commande,
            'panier' => $panier
        ];
    }
}
