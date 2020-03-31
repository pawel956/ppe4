<?php

namespace App\Controller;

use App\Entity\Habiter;
use App\Form\HabiterType;
use App\Repository\HabiterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/habiter")
 */
class HabiterController extends AbstractController
{
    /**
     * @Route("/", name="habiter_index", methods={"GET"})
     */
    public function index(HabiterRepository $habiterRepository): Response
    {
        return $this->render('habiter/index.html.twig', [
            'habiters' => $habiterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="habiter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $habiter = new Habiter();
        $form = $this->createForm(HabiterType::class, $habiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($habiter);
            $entityManager->flush();

            return $this->redirectToRoute('habiter_index');
        }

        return $this->render('habiter/new.html.twig', [
            'habiter' => $habiter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="habiter_show", methods={"GET"})
     */
    public function show(Habiter $habiter): Response
    {
        return $this->render('habiter/show.html.twig', [
            'habiter' => $habiter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="habiter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Habiter $habiter): Response
    {
        $form = $this->createForm(HabiterType::class, $habiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('habiter_index');
        }

        return $this->render('habiter/edit.html.twig', [
            'habiter' => $habiter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="habiter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Habiter $habiter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$habiter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($habiter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('habiter_index');
    }
}
