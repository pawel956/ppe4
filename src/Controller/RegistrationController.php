<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Constants;
use App\Entity\Habiter;
use App\Entity\Pays;
use App\Entity\Propriete;
use App\Entity\Region;
use App\Entity\Utilisateur;
use App\Entity\Ville;
use App\Form\RegistrationFormType;
use App\Form\RegistrationTwoFormType;
use App\Service\AdresseService;
use App\Service\HabiterService;
use App\Service\ImageService;
use App\Service\PartialsService;
use App\Service\PaysService;
use App\Service\ProprieteService;
use App\Service\RegionService;
use App\Service\UtilisateurService;
use App\Service\VilleService;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param ImageService $imageService
     * @param UtilisateurService $utilisateurService
     * @param Swift_Mailer $mailer
     * @param PartialsService $partialsService
     * @return Response
     */
    public function register(Request $request, ImageService $imageService, UtilisateurService $utilisateurService, Swift_Mailer $mailer, PartialsService $partialsService): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('idImage')->getData();

            // this condition is needed because the file field is not required
            // so the file must be processed only when a file is uploaded
            if ($file) {
                $user->setIdImage($imageService->upload($file));
            }

            $token = rand(100000, 999999);
            $user->setToken(sha1($token));
            $utilisateurService->save($user);

            $data = [
                'domain' => $request->getHost(),
                'id' => $user->getId(),
                'prenom' => $user->getPrenom(),
                'token' => $token
            ];

            $message = (new Swift_Message('Confirmation de votre compte Games Market'))
                ->setFrom(Constants::EMAIL)
                ->setTo($user->getEmail())
                ->setBody($this->renderView('registration/confirmation_email.html.twig', [
                    'data' => $data
                ]), 'text/html');

            $mailer->send($message);

            $request->getSession()->set('userId', $user->getId());
            return $this->redirectToRoute('app_register_two');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'partials' => $partialsService->getData()
        ]);
    }

    /**
     * @Route("/register_two", name="app_register_two")
     * @param Request $request
     * @param PaysService $paysService
     * @param RegionService $regionService
     * @param VilleService $villeService
     * @param AdresseService $adresseService
     * @param ProprieteService $proprieteService
     * @param HabiterService $habiterService
     * @param PartialsService $partialsService
     * @return Response
     */
    public function registerTwo(Request $request, PaysService $paysService, RegionService $regionService, VilleService $villeService, AdresseService $adresseService, ProprieteService $proprieteService, HabiterService $habiterService, PartialsService $partialsService): Response
    {
        $session = $request->getSession();
        if (!$session->has('userId')) {
            return $this->redirectToRoute('app_register');
        }

        $propriete = new Propriete();
        $form = $this->createForm(RegistrationTwoFormType::class, $propriete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pays = new Pays();
            $pays->setLibelle($form->get('pays')->getData());
            $paysService->save($pays);
            // Countries::getName('FR') -> France

            $region = new Region();
            $region->setLilbelle($form->get('region')->getData());
            $region->setIdPays($pays);
            $regionService->save($region);

            $ville = new Ville();
            $ville->setLibelle($form->get('ville')->getData());
            $ville->setCodePostal($form->get('codePostal')->getData());
            $ville->setIdRegion($region);
            $villeService->save($ville);

            $adresse = new Adresse();
            $adresse->setLibelle($form->get('rue')->getData());
            $adresse->setIdVille($ville);
            $adresseService->save($adresse);

            $propriete->setIdAdresse($adresse);
            $proprieteService->save($propriete);

            /** @var Utilisateur $user */
            $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['id' => $session->get('userId')]);
            $session->remove('userId');

            $habiter = new Habiter();
            $habiter->setDescription($form->get('description')->getData());
            $habiter->setIdUtilisateur($user);
            $habiter->setIdPropriete($propriete);
            $habiterService->save($habiter);

            $this->get('session')->getFlashBag()->set(
                'info',
                'Veuillez consulter vos mails pour valider votre compte.'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register_two.html.twig', [
            'registrationForm' => $form->createView(),
            'partials' => $partialsService->getData()
        ]);
    }

    /**
     * @Route("/checkemail", name="check_email", methods={"POST"})
     * @param Request $request
     * @param UtilisateurService $utilisateurService
     * @return Response
     */
    public function checkEmail(Request $request, UtilisateurService $utilisateurService)
    {
        // is it an Ajax request ?
        if ($request->isXmlHttpRequest()) {
            // get the value of a $_POST parameter
            $email = $request->request->get('email');
            if ($email) {
                $response = new Response();

                $response->setContent(json_encode([
                    'success' => $utilisateurService->checkEmail($email)
                ]));

                $response->headers->set('Content-Type', 'application/json');

                return $response;
            }
        }

        return new Response();
    }

    /**
     * @Route("/checkaccount/{id}/{token}", name="check_account", methods={"GET"})
     * @param Utilisateur $utilisateur
     * @param string $token
     * @param UtilisateurService $utilisateurService
     * @return Response
     */
    public function confirmAccount(Utilisateur $utilisateur, string $token, UtilisateurService $utilisateurService)
    {
        if ($utilisateur->getToken() == sha1($token)) {
            $utilisateur->setToken(null);
            $utilisateurService->save($utilisateur);

            $this->get('session')->getFlashBag()->set(
                'success',
                'Merci, votre compte a été validé !'
            );
        } elseif (is_null($utilisateur->getToken())) {
            $this->get('session')->getFlashBag()->set(
                'info',
                'Votre compte a déjà été validé.'
            );
        } else {
            $this->get('session')->getFlashBag()->set(
                'error',
                'Votre compte n\'a pas été validé !'
            );
        }

        return $this->redirectToRoute('app_login');
    }
}
