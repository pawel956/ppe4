<?php

namespace App\Controller;

use App\Entity\Constants;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\PartialsRepository;
use App\Service\ImageService;
use App\Service\UtilisateurService;
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
     * @param PartialsRepository $partialsRepository
     * @return Response
     */
    public function register(Request $request, ImageService $imageService, UtilisateurService $utilisateurService, Swift_Mailer $mailer, PartialsRepository $partialsRepository): Response
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

            $user->setToken(sha1(rand(100000, 999999)));
            $utilisateurService->save($user);

            $data = [
                'domain' => Constants::DOMAIN_NAME,
                'id' => $user->getId(),
                'prenom' => $user->getPrenom(),
                'token' => $user->getToken()
            ];

            $message = (new Swift_Message('Confirmation de votre compte GamesMarket'))
                ->setFrom(Constants::EMAIL)
                ->setTo($user->getEmail())
                ->setBody($this->renderView('registration/confirmation_email.html.twig', [
                    'data' => $data
                ]), 'text/html');

            $mailer->send($message);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'partials' => $partialsRepository->getData()
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
        if ($utilisateur->getToken() == $token) {
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
