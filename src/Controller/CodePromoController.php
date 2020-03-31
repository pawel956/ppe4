<?php

namespace App\Controller;

use App\Entity\CodePromo;
use App\Form\CodePromoType;
use App\Repository\CodePromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/code/promo")
 */
class CodePromoController extends AbstractController
{
    /**
     * @Route("/", name="code_promo_index", methods={"GET"})
     */
    public function index(CodePromoRepository $codePromoRepository): Response
    {
        return $this->render('code_promo/index.html.twig', [
            'code_promos' => $codePromoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="code_promo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $codePromo = new CodePromo();
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($codePromo);
            $entityManager->flush();

            return $this->redirectToRoute('code_promo_index');
        }

        return $this->render('code_promo/new.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="code_promo_show", methods={"GET"})
     */
    public function show(CodePromo $codePromo): Response
    {
        return $this->render('code_promo/show.html.twig', [
            'code_promo' => $codePromo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="code_promo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CodePromo $codePromo): Response
    {
        $form = $this->createForm(CodePromoType::class, $codePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('code_promo_index');
        }

        return $this->render('code_promo/edit.html.twig', [
            'code_promo' => $codePromo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="code_promo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CodePromo $codePromo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$codePromo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($codePromo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('code_promo_index');
    }
}
