<?php

namespace App\Controller;

use App\Entity\Destinataire;
use App\Form\DestinataireType;
use App\Repository\DestinataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/destinataire")
 */
class DestinataireController extends AbstractController
{
    /**
     * @Route("/destinataire/new", name="destinataire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $destinataire = new Destinataire();
        $form = $this->createForm(DestinataireType::class, $destinataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($destinataire);
            $entityManager->flush();

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('destinataire/new.html.twig', [
            'destinataire' => $destinataire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/destinataire/{id}", name="destinataire_show", methods={"GET"})
     */
    public function show(Destinataire $destinataire): Response
    {
        return $this->render('destinataire/show.html.twig', [
            'destinataire' => $destinataire,
        ]);
    }

    /**
     * @Route("/destinataire/{id}/edit", name="destinataire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Destinataire $destinataire): Response
    {
        $form = $this->createForm(DestinataireType::class, $destinataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('destinataire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('destinataire/edit.html.twig', [
            'destinataire' => $destinataire,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/destinataire/{id}/delete", name="destinataire_delete", methods={"POST"})
     */
    public function delete(Request $request, Destinataire $destinataire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$destinataire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($destinataire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('destinataire_index', [], Response::HTTP_SEE_OTHER);
    }
}
