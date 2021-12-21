<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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

    /**
     * @Route("/member/{user}", name="member_touits", methods={"GET"})
     * @isGranted("ROLE_USER");
     */
    public function memberTouits(User $user): Response
    {
        return $this->render('member/showTouits.html.twig', ['member' => $user]);
    }
}
