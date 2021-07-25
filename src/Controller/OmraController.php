<?php

namespace App\Controller;

use App\Entity\Omra;
use App\Form\OmraType;
use App\Form\OmraAgentType;
use App\Repository\OmraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GrilleTarifaire;
use App\Form\ReservationType;
use App\Form\GrilleTarifaireType;
use App\Entity\AgenceVoyage;
use App\Entity\Client;
use App\Entity\Reservation;
use App\Repository\ClientRepository;
use App\Repository\GrilleTarifaireRepository;
use App\Repository\OffreRepository;

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
        $user=$this->getUser();
        $agencevoyage=$user->getAgencevoyage();
        if(! is_null($agencevoyage))
        $omras = $omraRepository->findByAgencevoyage($agencevoyage) ;
        else 
        $omras = $omraRepository->findAll() ;
        return $this->render('omra/index.html.twig', [
            'omras' => $omras ,
        ]);
    }

    /**
     * @Route("/new", name="omra_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $omra = new Omra();
        $form = $this->createForm(OmraAgentType::class, $omra);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $agence=$user->getAgencevoyage();
            $omra->setAgencevoyage($agence);
            $entityManager->persist($omra);
            $entityManager->flush();

            return $this->redirectToRoute('omra_index');
        }

        return $this->render('omra/form.html.twig', [
            'omra' => $omra,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="omra_show", methods={"GET"})
     */
    public function show(Omra $omra,ClientRepository $clientRepository,Request $request): Response
    { $clients= $clientRepository->findAll();
        return $this->render('omra/show.html.twig', [
            'omra' => $omra,
            'clients'=>$clients,
        ]);
    }
 /**
     * @Route("/reservation/offre", name="omra_reservation", methods={"POST"})
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
     * @Route("/{id}/edit", name="omra_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Omra $omra): Response
    {
        $form = $this->createForm(OmraAgentType::class, $omra);
        $form->handleRequest($request);
        $grilletarifaire = new Grilletarifaire();
        $formgrille = $this->createForm(GrilleTarifaireType::class, $grilletarifaire);
        $formgrille->handleRequest($request);
        
        $grilletarifaires= $omra->getGrilletarifaires(); 
        if ($formgrille->isSubmitted() && $formgrille->isValid()) {
            $grilletarifaire->setOffre($omra);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grilletarifaire);
            $entityManager->flush();
          

            return $this->redirectToRoute('omra_edit', ['id' => $omra->getId()] );
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('omra_index');
        }

        return $this->render('omra/form.html.twig', [
            'grilletarifaires' => $grilletarifaires,
            'omra' => $omra,
            'form' => $form->createView(),
            'formgrille' => $formgrille->createView(),
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
