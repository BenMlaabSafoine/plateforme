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
use App\Form\ReservationType;
use App\Entity\Client;
use App\Entity\Reservation;
use App\Repository\ClientRepository;
use App\Repository\GrilleTarifaireRepository;
use App\Repository\OffreRepository;


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
        $user=$this->getUser();
        $agencevoyage=$user->getAgencevoyage();
        if(! is_null($agencevoyage))
        $croissieres = $croissiereRepository->findByAgencevoyage($agencevoyage) ;
        else 
        $croissieres = $croissiereRepository->findAll() ;
        return $this->render('croissiere/index.html.twig', [
            'croissieres' => $croissieres ,
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
    public function show(Croissiere $croissiere,ClientRepository $clientRepository,Request $request): Response
    {$clients= $clientRepository->findAll();
        return $this->render('croissiere/show.html.twig', [
            'croissiere' => $croissiere,
            'clients'=>$clients,
        ]);
    }
/**
     * @Route("/reservation/offre", name="croissiere_reservation", methods={"POST"})
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
