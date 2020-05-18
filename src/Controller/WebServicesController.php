<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Service\ProduitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api", name="api_")
 */
class WebServicesController extends AbstractController
{
    /**
     * @Route("/produit/all", name="produit_all", methods={"GET"})
     */
    public function webserviceProduitAll(): Response
    {
        $lesProduits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $reponse = new Response();
        $reponse->setContent($serializer->serialize($lesProduits, 'json'));
        $reponse->headers->set('Content-Type', 'application/json');
        return $reponse;
    }

    /**
     * @Route("/produit/delete", name="produit_delete", methods={"POST"})
     * @param Request $request
     * @param ProduitService $produitService
     * @return Response
     */
    public function webserviceProduitDeleteById(Request $request, ProduitService $produitService): Response
    {
        /** @var Produit $produit */
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(array('id' => $request->request->get('id')));

        if ($produit == null) {
            $array['error'] = true;
            return new Response(json_encode($array));
        }

        $produitService->deleteFull($produit);

        $array['error'] = false;
        return new Response(json_encode($array));
    }
}
