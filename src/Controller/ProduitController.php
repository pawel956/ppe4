<?php

namespace App\Controller;

use App\Entity\Constants;
use App\Repository\ImageRepository;
use App\Repository\PlateformeRepository;
use App\Repository\ProduitRepository;
use App\Repository\TypeProduitRepository;
use App\Service\PanierService;
use App\Service\PartialsService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produits", name="produits", methods={"GET", "POST"})
     * @param Request $request
     * @param PlateformeRepository $plateformeRepository
     * @param TypeProduitRepository $typeProduitRepository
     * @param ProduitRepository $produitRepository
     * @param PartialsService $partialsService
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PlateformeRepository $plateformeRepository, TypeProduitRepository $typeProduitRepository, ProduitRepository $produitRepository, PartialsService $partialsService, PaginatorInterface $paginator)
    {
        $idPlateforme = $request->request->get('idPlateforme');
        $idTypeProduit = $request->request->get('idTypeProduit');

        // pour récupérer les paramètres après avoir changer de pages knp_paginator
        if (is_null($idPlateforme) && is_null($idTypeProduit)) {
            $session = $request->getSession();
            $idPlateforme = $session->get('idPlateforme');
            $idTypeProduit = $session->get('idTypeProduit');
        }

        $plateforme = $plateformeRepository->findOneBy(['id' => $idPlateforme]);
        $typeProduit = $typeProduitRepository->findOneBy(['id' => $idTypeProduit]);

        if (is_null($plateforme) || (!is_null($idTypeProduit) && is_null($typeProduit))) {
            return $this->redirectToRoute('index');
        }

        // pour garder les paramètres entre les pages knp_paginator
        $session = $request->getSession();
        $session->set('idPlateforme', $idPlateforme);
        $session->set('idTypeProduit', $idTypeProduit);

        if (!is_null($typeProduit)) {
            $produits = $produitRepository->findProductsByPlatform($plateforme, $typeProduit);
        } else {
            $produits = $produitRepository->findProductsByPlatform($plateforme);
        }

        $produits_paginator = $paginator->paginate(
            $produits,
            $request->query->getInt('page', 1),
            3
        );

        $produits_paginator->setCustomParameters([
            'align' => 'center'
        ]);

        $images = $produitRepository->findProductsPictures($produits_paginator->getItems());

        $data = [
            'partials' => $partialsService->getData(),
            'plateforme' => $plateforme,
            'produits' => $produits_paginator,
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
