<?php

namespace App\Controller;

use App\Entity\AgenceVoyage;
use App\Entity\User;

use App\Form\AgenceVoyageType;
use App\Repository\AgenceVoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agence/voyage")
 */
class AgenceVoyageController extends AbstractController
{
    /**
     * @Route("/", name="agence_voyage_index", methods={"GET"})
     */
    public function index(AgenceVoyageRepository $agenceVoyageRepository): Response
    {
        return $this->render('agence_voyage/index.html.twig', [
            'agence_voyages' => $agenceVoyageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="agence_voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $agenceVoyage = new AgenceVoyage();
        $form = $this->createForm(AgenceVoyageType::class, $agenceVoyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agenceVoyage);
            $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('id'=>$agenceVoyage->getAgent()));
            foreach($user as $u){
              $u->setAgenceVoyage($agenceVoyage);
            }
            $entityManager->flush();

            return $this->redirectToRoute('agence_voyage_index');
        }

        return $this->render('agence_voyage/new.html.twig', [
            'agence_voyage' => $agenceVoyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agence_voyage_show", methods={"GET"})
     */
    public function show(AgenceVoyage $agenceVoyage): Response
    {
        return $this->render('agence_voyage/show.html.twig', [
            'agence_voyage' => $agenceVoyage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agence_voyage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AgenceVoyage $agenceVoyage): Response
    {
        $form = $this->createForm(AgenceVoyageType::class, $agenceVoyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agence_voyage_index');
        }

        return $this->render('agence_voyage/edit.html.twig', [
            'agence_voyage' => $agenceVoyage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agence_voyage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AgenceVoyage $agenceVoyage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agenceVoyage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agenceVoyage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agence_voyage_index');
    }
}
