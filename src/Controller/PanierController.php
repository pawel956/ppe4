<?php

namespace App\Controller;

use App\Entity\Constants;
use App\Entity\Panier;
use App\Entity\Utilisateur;
use App\Repository\CommandeRepository;
use App\Repository\HabiterRepository;
use App\Repository\ModeLivraisonRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use App\Repository\ProprieteRepository;
use App\Service\CommandeService;
use App\Service\PartialsService;
use DateTime;
use Knp\Snappy\Pdf;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
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
     * @param Request $request
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param CommandeService $commandeService
     * @param ProduitRepository $produitRepository
     * @param ModeLivraisonRepository $modeLivraisonRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function modeLivraison(Request $request, CommandeRepository $commandeRepository, PanierRepository $panierRepository, ModeLivraisonRepository $modeLivraisonRepository, CommandeService $commandeService, ProduitRepository $produitRepository, PartialsService $partialsService)
    {
        $data = $this->getMainData($commandeRepository, $panierRepository);

        if ($request->getMethod() === 'POST') {
            $modeLivraison = $modeLivraisonRepository->findOneBy(['id' => $request->request->get('mode_livraison')]);
            $data['commande']->setIdModeLivraison($modeLivraison);
            $commandeService->save($data['commande']);

            return $this->redirectToRoute('panier_paiement');
        }

        $modeLivraison = null;
        $idModeLivraison = $data['commande']->getIdModeLivraison();
        if ($idModeLivraison) {
            $modeLivraison = $modeLivraisonRepository->findOneBy(['id' => $idModeLivraison]);
        }

        return $this->render('panier/mode_livraison.html.twig', [
            'partials' => $partialsService->getData(),
            'panier' => $data['panier'],
            'qtePanier' => $panierRepository->numberProducts($data['commande']),
            'totalPanier' => $panierRepository->totalPanier($data['commande']),
            'modesLivraison' => $modeLivraisonRepository->findAll(),
            'choixModeLivraison' => $modeLivraison,
            'productPicturesDirectory' => Constants::PRODUCT_PICTURES_DIRECTORY_TWIG
        ]);
    }

    /**
     * @Route("/paiement", name="paiement")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param HabiterRepository $habiterRepository
     * @param ModeLivraisonRepository $modeLivraisonRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function paiement(CommandeRepository $commandeRepository, PanierRepository $panierRepository, HabiterRepository $habiterRepository, ModeLivraisonRepository $modeLivraisonRepository, PartialsService $partialsService)
    {
        $data = $this->getMainData($commandeRepository, $panierRepository);

        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();

        $panierJSON = null;
        foreach ($data['panier'] as $key => $produit) {
            /** @var Panier $produit */
            $panierJSON[$key] = [
                'name' => $produit->getIdProduit()->getLibelle(),
                'unit_amount' => ['currency_code' => 'EUR', 'value' => (float)number_format($produit->getPrix(), 2)],
//                'tax' => ['currency_code' => 'EUR', 'value' => (float)number_format($produit->getPrix() * 0.2, 2)],
                'quantity' => $produit->getQuantite(),
                'description' => $produit->getIdProduit()->getDescription(),
                'category' => $produit->getIdProduit()->getIdTypeProduit()->getLibelle() != 'Cartes prépayées' ? 'PHYSICAL_GOODS' : 'DIGITAL_GOODS'
            ];
        }

        $panierJSON = json_encode($panierJSON);

        return $this->render('panier/paiement.html.twig', [
            'partials' => $partialsService->getData(),
            'panier' => $data['panier'],
            'panierJSON' => $panierJSON,
            'qtePanier' => $panierRepository->numberProducts($data['commande']),
            'totalPanier' => $panierRepository->totalPanier($data['commande']),
            'choixModeLivraison' => $modeLivraisonRepository->findOneBy(['id' => $data['commande']->getIdModeLivraison()]),
            'adresse' => $habiterRepository->getFullDefaultAddress($utilisateur)[0],
            'paypalClientId' => Constants::PAYPAL_CLIENT_ID
        ]);
    }

    /**
     * @Route("/paiement_success", name="paiement_success")
     * @param CommandeRepository $commandeRepository
     * @param PanierRepository $panierRepository
     * @param Swift_Mailer $mailer
     * @param HabiterRepository $habiterRepository
     * @param KernelInterface $appKernel
     * @param Pdf $knpSnappy
     * @param ProprieteRepository $proprieteRepository
     * @param CommandeService $commandeService
     * @param PartialsService $partialsService
     * @return Response
     */
    public function paiementSuccess(CommandeRepository $commandeRepository, PanierRepository $panierRepository, Swift_Mailer $mailer, HabiterRepository $habiterRepository, KernelInterface $appKernel, Pdf $knpSnappy, ProprieteRepository $proprieteRepository, CommandeService $commandeService, PartialsService $partialsService)
    {
        $data = $this->getMainData($commandeRepository, $panierRepository);
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $total = $panierRepository->totalPanier($data['commande']);

        $newFilename = uniqid(rand() . '_');
        $newFilepath = $appKernel->getProjectDir() . Constants::FACTURE_FILE_DIRECTORY . '/' . $newFilename . '.pdf';

        $knpSnappy->generateFromHtml(
            $this->renderView('facture/commande.html.twig', [
                'commande' => $data['commande'],
                'panier' => $data['panier'],
                'adresse' => $habiterRepository->getFullDefaultAddress($utilisateur)[0],
                'totalPanier' => $total,
                'courriel' => Constants::EMAIL
            ]),
            $newFilepath
        );

        $message = (new Swift_Message('Confirmation de votre commande ' . array_values(Constants::EMAIL)[0] . ' n°' . $data['commande']->getId() ))
            ->setFrom(Constants::EMAIL)
            ->setTo($utilisateur->getEmail())
            ->setBody($this->renderView('panier/confirmation_email.html.twig', [
                'commande' => $data['commande'],
                'total' => $total,
                'courriel' => Constants::EMAIL
            ]), 'text/html')
            ->attach(Swift_Attachment::fromPath($newFilepath, 'application/pdf'));

        $mailer->send($message);

        $habiter = $habiterRepository->findOneBy(['idUtilisateur' => $this->getUser(), 'defaut' => true]);
        $propriete = $proprieteRepository->findOneBy(['id' => $habiter->getIdPropriete()]);

        $data['commande']->setIdPropriete($propriete);
        $data['commande']->setDateCommande(new DateTime());
        $data['commande']->setFacturePdf($newFilename);
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
