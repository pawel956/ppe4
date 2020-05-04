<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\TypeImage;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\PartialsRepository;
use App\Service\ImageService;
use App\Service\TypeImageService;
use App\Service\UtilisateurService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
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
     * @param PartialsRepository $partialsRepository
     * @return Response
     */
    public function register(Request $request, ImageService $imageService, UtilisateurService $utilisateurService, PartialsRepository $partialsRepository): Response
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

            $utilisateurService->save($user);

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'partials' => $partialsRepository->getData()
        ]);
    }

    /**
     * @Route("/checkemail", name="check_email")
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
    }
}
