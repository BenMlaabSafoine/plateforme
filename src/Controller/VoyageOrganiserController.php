<?php

namespace App\Controller;

use App\Entity\VoyageOrganiser;
use App\Entity\GrilleTarifaire;
use App\Entity\AgenceVoyage;
use App\Entity\Client;
use App\Entity\Reservation;
use App\Form\VoyageOrganiserType;
use App\Repository\VoyageOrganiserRepository;
use App\Repository\ClientRepository;
use App\Repository\GrilleTarifaireRepository;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\GrilleTarifaireType;
use App\Form\ReservationType;
use App\Form\VoyageOrganiserAgentType;

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
        $user=$this->getUser();
        $agencevoyage=$user->getAgencevoyage();
        if(! is_null($agencevoyage))
        $voyageorganisers = $voyageOrganiserRepository->findByAgencevoyage($agencevoyage) ;
        else 
        $voyageorganisers = $voyageOrganiserRepository->findAll() ;
        return $this->render('voyage_organiser/index.html.twig', [
            'voyage_organisers' => $voyageorganisers,
        ]);
    }

    /**
     * @Route("/new", name="voyage_organiser_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $voyageOrganiser = new VoyageOrganiser();
      //  if() // is admin
       // $form = $this->createForm(VoyageOrganiserType::class, $voyageOrganiser);
       // else
        $form=$this->createForm(VoyageOrganiserAgentType::class, $voyageOrganiser);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $agence=$user->getAgencevoyage();
            $voyageOrganiser->setAgencevoyage($agence);
            $entityManager->persist($voyageOrganiser);
            $entityManager->flush();

            return $this->redirectToRoute('voyage_organiser_index');
        }

        return $this->render('voyage_organiser/form.html.twig', [
            'voyage_organiser' => $voyageOrganiser,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/show/{id}", name="voyage_organiser_show", methods={"GET"})
     */
    public function show(VoyageOrganiser $voyageOrganiser,ClientRepository $clientRepository,Request $request): Response
    {   
       $clients= $clientRepository->findAll();
        return $this->render('voyage_organiser/show.html.twig', [
            'voyage_organiser' => $voyageOrganiser,
            'clients'=>$clients,
            
        ]);
        
        
    }


    
    /**
     * @Route("/reservation/offre", name="voyage_organiser_reservation", methods={"POST"})
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
     * @Route("/{id}/edit", name="voyage_organiser_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VoyageOrganiser $voyageOrganiser): Response
    {
        $form = $this->createForm(VoyageOrganiserAgentType::class, $voyageOrganiser);
        $form->handleRequest($request);
        
        $grilletarifaire = new Grilletarifaire();
        $formgrille = $this->createForm(GrilleTarifaireType::class, $grilletarifaire);
        $formgrille->handleRequest($request);
        
        $grilletarifaires= $voyageOrganiser->getGrilletarifaires(); 


        
        if ($formgrille->isSubmitted() && $formgrille->isValid()) {
            $grilletarifaire->setOffre($voyageOrganiser);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grilletarifaire);
            $entityManager->flush();
          

            return $this->redirectToRoute('voyage_organiser_edit', ['id' => $voyageOrganiser->getId()] );
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voyageOrganiser);
            $entityManager->flush();
          

            return $this->redirectToRoute('voyage_organiser_index');
        }

        return $this->render('voyage_organiser/form.html.twig', [
            'grilletarifaires' => $grilletarifaires,
            'voyage_organiser' => $voyageOrganiser,
            'form' => $form->createView(),
            'formgrille' => $formgrille->createView(),
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
