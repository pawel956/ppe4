<?php

namespace App\Controller;

use App\Entity\Constants;
use App\Repository\ImageRepository;
use App\Repository\PlateformeRepository;
use App\Repository\ProduitRepository;
use App\Repository\TypeProduitRepository;
use App\Service\PanierService;
use App\Service\PartialsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits", methods={"POST"})
     * @param Request $request
     * @param PlateformeRepository $plateformeRepository
     * @param TypeProduitRepository $typeProduitRepository
     * @param ProduitRepository $produitRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function index(Request $request, PlateformeRepository $plateformeRepository, TypeProduitRepository $typeProduitRepository, ProduitRepository $produitRepository, PartialsService $partialsService)
    {
        $idPlateforme = $request->request->get('idPlateforme');
        $idTypeProduit = $request->request->get('idTypeProduit');

        $plateforme = $plateformeRepository->findOneBy(['id' => $idPlateforme]);
        $typeProduit = $typeProduitRepository->findOneBy(['id' => $idTypeProduit]);

        if (is_null($plateforme) || (!is_null($idTypeProduit) && is_null($typeProduit))) {
            return $this->redirectToRoute('index');
        }

        if (!is_null($typeProduit)) {
            $produits = $produitRepository->findProductsByPlatform($plateforme, $typeProduit);
        } else {
            $produits = $produitRepository->findProductsByPlatform($plateforme);
        }

        $images = $produitRepository->findProductsPictures($produits);

        $data = [
            'partials' => $partialsService->getData(),
            'plateforme' => $plateforme,
            'produits' => $produits,
            'images' => $images,
            'produitPicturesDirectory' => Constants::PRODUCT_PICTURES_DIRECTORY_BIS
        ];

        if (!is_null($typeProduit)) {
            $data['typeProduit'] = $typeProduit;
        }

        return $this->render('produit/produits.html.twig', $data);
    }

    /**
     * @Route("/produit", name="produit", methods={"POST"})
     * @param Request $request
     * @param ProduitRepository $produitRepository
     * @param ImageRepository $imageRepository
     * @param PartialsService $partialsService
     * @return Response
     */
    public function indexProduit(Request $request, ProduitRepository $produitRepository, ImageRepository $imageRepository, PartialsService $partialsService)
    {
        $idProduit = $request->request->get('idProduit');
        $produit = $produitRepository->findOneBy(['id' => $idProduit]);

        if (is_null($produit)) {
            return $this->redirectToRoute('index');
        }

        $images = $imageRepository->findBy(['idProduit' => $idProduit]);

        return $this->render('produit/produit.html.twig', [
            'partials' => $partialsService->getData(),
            'produit' => $produit,
            'images' => $images,
            'produitPicturesDirectory' => Constants::PRODUCT_PICTURES_DIRECTORY_BIS
        ]);
    }

    /**
     * @Route("/add_panier", name="add_panier", methods={"POST"})
     * @param Request $request
     * @param PanierService $panierService
     * @return Response
     */
    public function addPanier(Request $request, PanierService $panierService)
    {
        // is it an Ajax request ?
        if ($request->isXmlHttpRequest()) {
            // get the value of a $_POST parameter
            $idProduit = $request->request->get('idProduit');
            if ($idProduit) {
                $response = new Response();

                $response->setContent(json_encode([
                    'success' => $panierService->addProduct($idProduit, $this->getUser()->getId()),
                    'panier' => $panierService->panierData($this->getUser()->getId(), true)
                ]));

                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
        }

        return new Response();
    }

    /**
     * @Route("/remove_panier", name="remove_panier", methods={"POST"})
     * @param Request $request
     * @param PanierService $panierService
     * @return Response
     */
    public function removePanier(Request $request, PanierService $panierService)
    {
        // is it an Ajax request ?
        if ($request->isXmlHttpRequest()) {
            // get the value of a $_POST parameter
            $idProduit = $request->request->get('idProduit');
            if ($idProduit) {
                $response = new Response();

                $response->setContent(json_encode([
                    'success' => $panierService->removeProduct($idProduit, $this->getUser()->getId()),
                    'panier' => $panierService->panierData($this->getUser()->getId(), true)
                ]));

                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
        }

        return new Response();
    }
}
