<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

/**
 * @Route("/agent")
 */
class AgentController extends AbstractController
{
    /**
     * @Route("/", name="agent_index", methods={"GET"})
     */
    public function index(AgentRepository $agentRepository): Response
    {
        return $this->render('agent/index.html.twig', [
            'agents' => $agentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="agent_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agent->setPassword(
                $passwordEncoder->encodePassword(
                    $agent,
                   $agent->getPassword()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $roles[]='ROLE_AGENT';
            $agent->setRoles($roles);
            $entityManager->persist($agent);
            $entityManager->flush();

            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('agent_index');
        }

        return $this->render('agent/new.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_show", methods={"GET"})
     */
    public function show(Agent $agent): Response
    {
        return $this->render('agent/show.html.twig', [
            'agent' => $agent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Agent $agent): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $roles[]='ROLE_AGENT';
            $agent->setRoles($roles);
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('agent_index');
        }

        return $this->render('agent/edit.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Agent $agent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agent_index');
    }
}
