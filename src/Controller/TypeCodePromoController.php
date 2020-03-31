<?php

namespace App\Controller;

use App\Entity\TypeCodePromo;
use App\Form\TypeCodePromoType;
use App\Repository\TypeCodePromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/code/promo")
 */
class TypeCodePromoController extends AbstractController
{
    /**
     * @Route("/", name="type_code_promo_index", methods={"GET"})
     */
    public function index(TypeCodePromoRepository $typeCodePromoRepository): Response
    {
        return $this->render('type_code_promo/index.html.twig', [
            'type_code_promos' => $typeCodePromoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_code_promo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeCodePromo = new TypeCodePromo();
        $form = $this->createForm(TypeCodePromoType::class, $typeCodePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeCodePromo);
            $entityManager->flush();

            return $this->redirectToRoute('type_code_promo_index');
        }

        return $this->render('type_code_promo/new.html.twig', [
            'type_code_promo' => $typeCodePromo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_code_promo_show", methods={"GET"})
     */
    public function show(TypeCodePromo $typeCodePromo): Response
    {
        return $this->render('type_code_promo/show.html.twig', [
            'type_code_promo' => $typeCodePromo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_code_promo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeCodePromo $typeCodePromo): Response
    {
        $form = $this->createForm(TypeCodePromoType::class, $typeCodePromo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_code_promo_index');
        }

        return $this->render('type_code_promo/edit.html.twig', [
            'type_code_promo' => $typeCodePromo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_code_promo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeCodePromo $typeCodePromo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeCodePromo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeCodePromo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_code_promo_index');
    }
}
