<?php

namespace App\Controller;

use App\Entity\GrilleTarifaire;
use App\Form\GrilleTarifaireType;
use App\Repository\GrilleTarifaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/grilletarifaire")
 */
class GrilleTarifaireController extends AbstractController
{
    /**
     * @Route("/", name="grille_tarifaire_index", methods={"GET"})
     */
    public function index(GrilleTarifaireRepository $grilleTarifaireRepository): Response
    {
        return $this->render('grille_tarifaire/index.html.twig', [
            'grille_tarifaires' => $grilleTarifaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="grille_tarifaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $grilleTarifaire = new GrilleTarifaire();
        $form = $this->createForm(GrilleTarifaireType::class, $grilleTarifaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grilleTarifaire);
            $entityManager->flush();

            return $this->redirectToRoute('grille_tarifaire_index');
        }

        return $this->render('grille_tarifaire/new.html.twig', [
            'grille_tarifaire' => $grilleTarifaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grille_tarifaire_show", methods={"GET"})
     */
    public function show(GrilleTarifaire $grilleTarifaire): Response
    {
        return $this->render('grille_tarifaire/show.html.twig', [
            'grille_tarifaire' => $grilleTarifaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="grille_tarifaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GrilleTarifaire $grilleTarifaire): Response
    {
        $form = $this->createForm(GrilleTarifaireType::class, $grilleTarifaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grille_tarifaire_index');
        }

        return $this->render('grille_tarifaire/edit.html.twig', [
            'grille_tarifaire' => $grilleTarifaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="grille_tarifaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GrilleTarifaire $grilleTarifaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grilleTarifaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grilleTarifaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('grille_tarifaire_index');
    }
     /**
     * @Route("/del/{id}", name="grille_tarifaire_del")
     */
    public function del(Request $request, GrilleTarifaire $grilleTarifaire): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $offre=$grilleTarifaire->getOffre();
            $entityManager->remove($grilleTarifaire);
            $entityManager->flush();
/*
             switch ($offre->getType()) {
                 case 'value':
                     $path=
                     break;
                 
                 default:
                     # code...
                     break;
             }

        return $this->redirectToRoute($path);*/
        
        return $this->redirectToRoute('offre_index');
    }
}
