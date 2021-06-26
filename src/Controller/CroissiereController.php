<?php

namespace App\Controller;

use App\Entity\Croissiere;
use App\Form\CroissiereType;
use App\Form\CroissiereAgentType;
use App\Entity\AgenceVoyage;
use App\Repository\CroissiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GrilleTarifaire;
use App\Form\GrilleTarifaireType;


/**
 * @Route("/croissiere")
 */
class CroissiereController extends AbstractController
{
    /**
     * @Route("/", name="croissiere_index", methods={"GET"})
     */
    public function index(CroissiereRepository $croissiereRepository): Response
    {
        return $this->render('croissiere/index.html.twig', [
            'croissieres' => $croissiereRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="croissiere_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $croissiere = new Croissiere();
        $form = $this->createForm(CroissiereAgentType::class, $croissiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $agence=$user->getAgencevoyage();
            $croissiere->setAgencevoyage($agence);
            $entityManager->persist($croissiere);
            
            $entityManager->flush();

            return $this->redirectToRoute('croissiere_index');
        }

        return $this->render('croissiere/form.html.twig', [
            'croissiere' => $croissiere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="croissiere_show", methods={"GET"})
     */
    public function show(Croissiere $croissiere): Response
    {
        return $this->render('croissiere/show.html.twig', [
            'croissiere' => $croissiere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="croissiere_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Croissiere $croissiere): Response
    {
        $form = $this->createForm(CroissiereAgentType::class, $croissiere);
        $form->handleRequest($request);
        $grilletarifaire = new Grilletarifaire();
        $formgrille = $this->createForm(GrilleTarifaireType::class, $grilletarifaire);
        $formgrille->handleRequest($request);
        
        $grilletarifaires= $croissiere->getGrilletarifaires(); 
        if ($formgrille->isSubmitted() && $formgrille->isValid()) {
            $grilletarifaire->setOffre($croissiere);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grilletarifaire);
            $entityManager->flush();
          

            return $this->redirectToRoute('croissiere_edit', ['id' => $croissiere->getId()] );
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('croissiere_index');
        }

        return $this->render('croissiere/form.html.twig', [
            'grilletarifaires' => $grilletarifaires,
            'croissiere' => $croissiere,
            'form' => $form->createView(),
            'formgrille' => $formgrille->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="croissiere_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Croissiere $croissiere): Response
    {
        if ($this->isCsrfTokenValid('delete'.$croissiere->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($croissiere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('croissiere_index');
    }
}
