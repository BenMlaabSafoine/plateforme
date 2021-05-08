<?php

namespace App\Controller;

use App\Entity\Omra;
use App\Form\OmraType;
use App\Repository\OmraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GrilleTarifaire;

/**
 * @Route("/omra")
 */
class OmraController extends AbstractController
{
    /**
     * @Route("/", name="omra_index", methods={"GET"})
     */
    public function index(OmraRepository $omraRepository): Response
    {
        return $this->render('omra/index.html.twig', [
            'omras' => $omraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="omra_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $omra = new Omra();
        $form = $this->createForm(OmraType::class, $omra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($omra);
            $grilleTarifaire = new GrilleTarifaire();
        $grilleTarifaire->setDescription($request->request->get("Description"));
        $grilleTarifaire->setOffre($omra);
        $entityManager->persist($grilleTarifaire);
            $entityManager->flush();

            return $this->redirectToRoute('omra_index');
        }

        return $this->render('omra/new.html.twig', [
            'omra' => $omra,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="omra_show", methods={"GET"})
     */
    public function show(Omra $omra): Response
    {
        return $this->render('omra/show.html.twig', [
            'omra' => $omra,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="omra_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Omra $omra): Response
    {
        $form = $this->createForm(OmraType::class, $omra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('omra_index');
        }

        return $this->render('omra/edit.html.twig', [
            'omra' => $omra,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="omra_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Omra $omra): Response
    {
        if ($this->isCsrfTokenValid('delete'.$omra->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($omra);
            $entityManager->flush();
        }

        return $this->redirectToRoute('omra_index');
    }
}
