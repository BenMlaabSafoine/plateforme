<?php

namespace App\Controller;

use App\Entity\Excursion;
use App\Form\ExcursionType;
use App\Form\ExcursionAgentType;
use App\Repository\ExcursionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\GrilleTarifaireType;
use App\Entity\GrilleTarifaire;
use App\Form\ReservationType;
use App\Entity\AgenceVoyage;
use App\Entity\Client;
use App\Entity\Reservation;
use App\Repository\ClientRepository;
use App\Repository\GrilleTarifaireRepository;
use App\Repository\OffreRepository;

/**
 * @Route("/excursion")
 */
class ExcursionController extends AbstractController
{
    /**
     * @Route("/", name="excursion_index", methods={"GET"})
     */
    public function index(ExcursionRepository $excursionRepository): Response
    {
        $user=$this->getUser();
        $agencevoyage=$user->getAgencevoyage();
        if(! is_null($agencevoyage))
        $excursions = $excursionRepository->findByAgencevoyage($agencevoyage) ;
        else 
        $excursions = $excursionRepository->findAll() ;
        return $this->render('excursion/index.html.twig', [
            'excursions' => $excursions,
        ]);
    }

    /**
     * @Route("/new", name="excursion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $excursion = new Excursion();
        $form = $this->createForm(ExcursionAgentType::class, $excursion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $agence=$user->getAgencevoyage();
            $excursion->setAgencevoyage($agence);
            $entityManager->persist($excursion);
            $entityManager->flush();

            return $this->redirectToRoute('excursion_index');
        }

        return $this->render('excursion/form.html.twig', [
            'excursion' => $excursion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="excursion_show", methods={"GET"})
     */
    public function show(Excursion $excursion,ClientRepository $clientRepository,Request $request): Response
    {$clients= $clientRepository->findAll();
        return $this->render('excursion/show.html.twig', [
            'excursion' => $excursion,
            'clients'=>$clients,
        ]);
    }
/**
     * @Route("/reservation/offre", name="excursion_reservation", methods={"POST"})
     */
    public function reservation(Request $request,ClientRepository $clientRepository,GrilleTarifaireRepository $grilletarifaireRepository,OffreRepository $offreRepository): Response
    {   
          
         $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            $reservation = new Reservation();

        $idclient = $request->request->get('client');
        $idgrilletarifaire = $request->request->get('grilletarifaire');
        $idoffre = $request->request->get('offre');

        $client =  $clientRepository->find($idclient);
        $grilletarifaire =  $grilletarifaireRepository->find($idgrilletarifaire);
        $offre =  $offreRepository->find($idoffre);
            $reservation->setClient($client);
            $reservation->setGrilleTarifaire($grilletarifaire);
            $reservation->setOffre($offre);
            $reservation->setAgenceVoyage($offre->getAgenceVoyage());
            $reservation->setStatut('nontraitee');
            $reservation->setDate(new \DateTime('now'));
            $em->persist($reservation);
            $em->flush();
          }
          return $this->redirectToRoute('reservation_index' );
    
        
        
    }
    /**
     * @Route("/{id}/edit", name="excursion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Excursion $excursion): Response
    {
        $form = $this->createForm(ExcursionAgentType::class, $excursion);
        $form->handleRequest($request);
        $grilletarifaire = new Grilletarifaire();
        $formgrille = $this->createForm(GrilleTarifaireType::class, $grilletarifaire);
        $formgrille->handleRequest($request);
        
        $grilletarifaires= $excursion->getGrilletarifaires(); 
        if ($formgrille->isSubmitted() && $formgrille->isValid()) {
            $grilletarifaire->setOffre($excursion);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grilletarifaire);
            $entityManager->flush();
          

            return $this->redirectToRoute('excursion_edit', ['id' => $excursion->getId()] );
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('excursion_index');
        }

        return $this->render('excursion/form.html.twig', [
            'grilletarifaires' => $grilletarifaires,
            'excursion' => $excursion,
            'form' => $form->createView(),
            'formgrille' => $formgrille->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="excursion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Excursion $excursion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$excursion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($excursion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('excursion_index');
    }
}
