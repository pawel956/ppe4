<?php

namespace App\Controller;

use App\Entity\Constants;
use App\Repository\ImageRepository;
use App\Repository\PartialsRepository;
use App\Repository\ProduitRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit", methods={"POST"})
     * @param Request $request
     * @param ProduitRepository $produitRepository
     * @param ImageRepository $imageRepository
     * @param PartialsRepository $partialsRepository
     * @return Response
     */
    public function index(Request $request, ProduitRepository $produitRepository, ImageRepository $imageRepository, PartialsRepository $partialsRepository)
    {
        $idProduit = $request->request->get('idProduit');
        $produit = $produitRepository->findOneBy(['id' => $idProduit]);
        $images = $imageRepository->findBy(['idProduit' => $idProduit]);

        if (is_null($produit)) {
            return $this->render('produit/produit.html.twig', [
                'partials' => $partialsRepository->getData()
            ]);
        }

        return $this->render('produit/produit.html.twig', [
            'partials' => $partialsRepository->getData(),
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
                    'success' => $panierService->addProduct($idProduit, $this->getUser()->getId())
                ]));

                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
        }

        return new Response();
    }
}
