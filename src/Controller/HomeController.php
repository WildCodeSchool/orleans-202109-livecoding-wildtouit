<?php

namespace App\Controller;

use App\Repository\TouitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(TouitRepository $touitRepository): Response
    {
        $touits = $touitRepository->findAll();
        return $this->render('home/index.html.twig', ['touits' => $touits]);
    }
}
