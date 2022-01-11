<?php

namespace App\Controller;

use App\Entity\User;
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
        if ($this->isGranted('ROLE_USER')) {
            $user = $this->getUser();
            if ($user instanceof User) {
                $touits = $touitRepository->findFromFollowedUsers($user);
            }
        } else {
            $touits = $touitRepository->findAll();
        }
        return $this->render('home/index.html.twig', ['touits' => $touits ?? []]);
    }
}
