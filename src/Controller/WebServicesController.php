<?php

namespace App\Controller;

use App\Entity\Constants;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Repository\GenreRepository;
use App\Service\ProduitService;
use App\Service\UtilisateurService;
use Swift_Mailer;
use Swift_Message;
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

    /**
     * @Route("/utilisateur/add", name="utilisateur_add", methods={"POST"})
     * @param Request $request
     * @param UtilisateurService $utilisateurService
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function webserviceUtilisateurAdd(Request $request, GenreRepository $genreRepository, UtilisateurService $utilisateurService, Swift_Mailer $mailer): Response
    {
        $genre = $genreRepository->findOneBy(['libelle' => $request->request->get('genre')]);

        $utilisateur = new Utilisateur();
        $utilisateur->setNom($request->request->get('nom'));
        $utilisateur->setPrenom($request->request->get('prenom'));
        $utilisateur->setEmail($request->request->get('email'));
        $utilisateur->setTelephone($request->request->get('telephone'));
        $utilisateur->setIdGenre($genre);
        $utilisateur->setDateNaissance($request->request->get('dateNaissance'));
        $utilisateur->setPlainPassword($request->request->get('mdp'));

        $token = rand(100000, 999999);
        $utilisateur->setToken(sha1($token));
        $utilisateurService->save($utilisateur);

        $data = [
            'id' => $utilisateur->getId(),
            'prenom' => $utilisateur->getPrenom(),
            'token' => $token,
            'courriel' => Constants::EMAIL
        ];

        $message = (new Swift_Message('Confirmation de votre compte ' . array_values(Constants::EMAIL)[0]))
            ->setFrom(Constants::EMAIL)
            ->setTo($utilisateur->getEmail())
            ->setBody($this->renderView('registration/confirmation_email.html.twig', [
                'data' => $data
            ]), 'text/html');

        $mailer->send($message);

        $array['error'] = false;
        return new Response(json_encode($array));
    }
}
