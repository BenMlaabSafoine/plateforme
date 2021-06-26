<?php

namespace App\Controller;

use App\Entity\AgenceVoyage;
use App\Entity\User;
use App\Entity\Agent;

use App\Form\AgenceVoyageType;
use App\Repository\AgenceVoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    function rand_chars($c, $l, $u = FALSE) {
    if (!$u) for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c{$x}, $i++);
    else for ($i = 0, $z = strlen($c)-1, $s = $c{rand(0,$z)}, $i = 1; $i != $l; $x = rand(0,$z), $s .= $c{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s));
    return $s;
    }

    /**
     * @Route("/new", name="agence_voyage_new", methods={"GET","POST"})
     */
    public function new(Request $request,MailerInterface $mailer,UserPasswordEncoderInterface $passwordEncoder): Response
    {
       
        $agenceVoyage = new AgenceVoyage();
        $form = $this->createForm(AgenceVoyageType::class, $agenceVoyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
       
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agenceVoyage);
           // $user = $this->getDoctrine()
            //->getRepository(User::class)
            //->findBy(array('id'=>$agenceVoyage->getAgent()));
            //foreach($user as $u){
             // $u->setAgenceVoyage($agenceVoyage);
           // }
            $agent = new Agent();
            $roles[]='ROLE_AGENT';
            $agent->setRoles($roles);
            $agent->setNom($agenceVoyage->getNom());
            $agent->setPrenom($agenceVoyage->getNom());
            $agent->setNumtel($agenceVoyage->getNumtel());
            $agent->setEmail($agenceVoyage->getEmail());
            $agent->setAgenceVoyage($agenceVoyage);
            $password =$this->rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890",10);
            $agent->setPassword(
                $passwordEncoder->encodePassword(
                    $agent,
                    $password
                    )
            );
            $entityManager->persist($agent);
            $entityManager->flush();
            $email = (new Email())
            ->from('benmlaabsafoine@gmail.com')
            ->to($agent->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Compte Agence')
            ->text('Voice votre compte! username :'.$agent->getEmail().' votre mot de passe : '.$password);

        $mailer->send($email);
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
