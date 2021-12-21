<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $userRepository->findBy([], ['username' => 'ASC']),
        ]);
    }
}
