<?php

namespace App\Controller;

use App\Entity\Randonnee;
use App\Form\RandonneeType;
use App\Form\RandonneeAgentType;
use App\Repository\RandonneeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GrilleTarifaire;
use App\Form\GrilleTarifaireType;

/**
 * @Route("/randonnee")
 */
class RandonneeController extends AbstractController
{
    /**
     * @Route("/", name="randonnee_index", methods={"GET"})
     */
    public function index(RandonneeRepository $randonneeRepository): Response
    {
        return $this->render('randonnee/index.html.twig', [
            'randonnees' => $randonneeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="randonnee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $randonnee = new Randonnee();
        $form = $this->createForm(RandonneeType::class, $randonnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $agence=$user->getAgencevoyage();
            $randonnee->setAgencevoyage($agence);
            $entityManager->persist($randonnee);
            $entityManager->flush();

            return $this->redirectToRoute('randonnee_index');
        }

        return $this->render('randonnee/form.html.twig', [
            'randonnee' => $randonnee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="randonnee_show", methods={"GET"})
     */
    public function show(Randonnee $randonnee): Response
    {
        return $this->render('randonnee/show.html.twig', [
            'randonnee' => $randonnee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="randonnee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Randonnee $randonnee): Response
    {
        $form = $this->createForm(RandonneeAgentType::class, $randonnee);
        $form->handleRequest($request);
        $grilletarifaire = new Grilletarifaire();
        $formgrille = $this->createForm(GrilleTarifaireType::class, $grilletarifaire);
        $formgrille->handleRequest($request);
        
        $grilletarifaires= $randonnee->getGrilletarifaires(); 
        if ($formgrille->isSubmitted() && $formgrille->isValid()) {
            $grilletarifaire->setOffre($randonnee);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grilletarifaire);
            $entityManager->flush();
          

            return $this->redirectToRoute('randonnee_edit', ['id' => $randonnee->getId()] );
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('randonnee_index');
        }

        return $this->render('randonnee/form.html.twig', [
            'grilletarifaires' => $grilletarifaires,
            'randonnee' => $randonnee,
            'form' => $form->createView(),
            'formgrille' => $formgrille->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="randonnee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Randonnee $randonnee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$randonnee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($randonnee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('randonnee_index');
    }
}
