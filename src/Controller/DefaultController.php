<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Repository\AdminRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="inde", methods={"GET"})
     */
    public function index(AdminRepository $adminRepository): Response
    {
        return $this->redirectToRoute('app_login');

    }
}
