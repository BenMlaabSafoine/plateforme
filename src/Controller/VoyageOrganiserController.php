<?php

namespace App\Controller;

use App\Entity\VoyageOrganiser;
use App\Entity\GrilleTarifaire;


use App\Form\VoyageOrganiserType;
use App\Repository\VoyageOrganiserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voyage/organiser")
 */
class VoyageOrganiserController extends AbstractController
{
    /**
     * @Route("/", name="voyage_organiser_index", methods={"GET"})
     */
    public function index(VoyageOrganiserRepository $voyageOrganiserRepository): Response
    {
        return $this->render('voyage_organiser/index.html.twig', [
            'voyage_organisers' => $voyageOrganiserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="voyage_organiser_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $voyageOrganiser = new VoyageOrganiser();
        $form = $this->createForm(VoyageOrganiserType::class, $voyageOrganiser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyageOrganiser);
            $grilleTarifaire = new GrilleTarifaire();
        $grilleTarifaire->setDescription($request->request->get("Description"));
        $grilleTarifaire->setOffre($voyageOrganiser);
        $entityManager->persist($grilleTarifaire);

            $entityManager->flush();

            return $this->redirectToRoute('voyage_organiser_index');
        }

        return $this->render('voyage_organiser/new.html.twig', [
            'voyage_organiser' => $voyageOrganiser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_organiser_show", methods={"GET"})
     */
    public function show(VoyageOrganiser $voyageOrganiser): Response
    {
        return $this->render('voyage_organiser/show.html.twig', [
            'voyage_organiser' => $voyageOrganiser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="voyage_organiser_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VoyageOrganiser $voyageOrganiser): Response
    {
        $form = $this->createForm(VoyageOrganiserType::class, $voyageOrganiser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyage_organiser_index');
        }

        return $this->render('voyage_organiser/edit.html.twig', [
            'voyage_organiser' => $voyageOrganiser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voyage_organiser_delete", methods={"DELETE"})
     */
    public function delete(Request $request, VoyageOrganiser $voyageOrganiser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyageOrganiser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voyageOrganiser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voyage_organiser_index');
    }
}
