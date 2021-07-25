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
use App\Entity\AgenceVoyage;
use App\Entity\Client;
use App\Entity\Reservation;
use App\Repository\ClientRepository;
use App\Repository\GrilleTarifaireRepository;
use App\Repository\OffreRepository;
use App\Form\ReservationType;

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
        $user=$this->getUser();
        $agencevoyage=$user->getAgencevoyage();
        if(! is_null($agencevoyage))
        $randonnees = $randonneeRepository->findByAgencevoyage($agencevoyage) ;
        else 
        $randonnees = $randonneeRepository->findAll() ;
        return $this->render('randonnee/index.html.twig', [
            'randonnees' =>$randonnees,
        ]);
    }

    /**
     * @Route("/new", name="randonnee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $randonnee = new Randonnee();
        $form = $this->createForm(RandonneeAgentType::class, $randonnee);
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
    public function show(Randonnee $randonnee,ClientRepository $clientRepository,Request $request): Response
    { $clients= $clientRepository->findAll();
        return $this->render('randonnee/show.html.twig', [
            'randonnee' => $randonnee,
            'clients'=>$clients,
        ]);
    }
  /**
     * @Route("/reservation/offre", name="randonnee_reservation", methods={"POST"})
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
