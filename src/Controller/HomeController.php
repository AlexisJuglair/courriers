<?php

namespace App\Controller;

use App\Entity\Courrier;
use App\Entity\Suivi;
use App\Form\CourrierType;
use App\Repository\CourrierRepository;
use App\Repository\DestinataireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/", name="home_")
 * @IsGranted("ROLE_USER")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CourrierRepository $courrierRepository, DestinataireRepository $destinataireRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'courriers' => $courrierRepository->findBy(
                ['utilisateur' => $this->getUser()->getId()],
                ['dateModification' => 'DESC',
                'dateEnvoi' => 'DESC',]
            ),
            'destinataires' => $destinataireRepository->findBy(
                ['utilisateur' => $this->getUser()->getId()],
                ['denomination' => 'ASC',
                'prenom' => 'ASC',
                'nom' => 'ASC']
            ),
        ]);
    }

    /**
     * @Route("/courrier/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, Security $security): Response
    {
        $courrier = new Courrier();
        $form = $this->createForm(CourrierType::class, $courrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $courrier->setDateCreation(new \DateTime());
            $courrier->setDateModification($courrier->getDateCreation());
            $courrier->setUtilisateur($security->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($courrier);

            $entityManager->flush();

            $this->addFlash('success', "Le courrier a été ajouté !");

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/_form.html.twig', [
            'courrier' => $courrier,
            'form' => $form,
            'action' => 'Ajouter'
        ]);
    }


    /**
     * @Route("/courrier/{id}", name="show", methods={"GET"})
     */
    public function show(Courrier $courrier): Response
    {
        return $this->render('home/show.html.twig', [
            'courrier' => $courrier,
        ]);
    }

    /**
     * @Route("/courrier/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(CourrierRepository $courrierRepository, Request $request): Response
    {
        $referer = $request->headers->get('referer');
        $refererPathInfo = Request::create($referer)->getPathInfo();
        $current = $request->attributes->get('_route');

        if ($refererPathInfo == "/") 
        {
            if (isset($_POST['courriers']) && count($_POST['courriers']) == 1)
            {
                $courrier = $courrierRepository->find($_POST['courriers'][0]);
                $form = $this->createForm(CourrierType::class, $courrier);
                $form->handleRequest($request);
        
                return $this->renderForm('home/_form.html.twig', [
                    'courrier' => $courrier,
                    'form' => $form,
                    'action' => 'Modifier'
                ]);
            }
        }

        else if ($current == 'home_edit')
        {
            $courrier_id = $request->request->get('courrier')['id'];
            $courrier = $courrierRepository->find($courrier_id);

            $form = $this->createForm(CourrierType::class, $courrier);
            dd($courrier);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {
                $courrier->setDateModification(new \DateTime());
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', "Le courrier a été modifié !");
            }
        }

        return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER); 
    }

    /**
     * @Route("/courrier/delete", name="delete", methods={"POST"})
     */
    public function delete(CourrierRepository $courrierRepository): Response
    {
        if (isset($_POST['courriers']))
        {
            foreach ($_POST['courriers'] as $courrier_id) 
            {
                $courrier = $courrierRepository->find($courrier_id);
                // if ($this->isCsrfTokenValid('delete'.$courrier->getId(), $request->request->get('_token'))) 
                // {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($courrier);
                    $entityManager->flush();
                // }
            }
        }

        return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
    }
}
