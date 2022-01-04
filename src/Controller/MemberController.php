<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/member/profile", name="member_profile", methods={"GET"})
     * @isGranted("ROLE_USER");
     */
    public function profile(): Response
    {
        return $this->render('member/profile.html.twig');
    }

    /**
     * @Route("/member/profile/edit", name="member_profile_edit")
     * @isGranted("ROLE_USER");
     */
    public function editProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a bien été édité');
            return $this->redirectToRoute('member_profile');
        }

        return $this->render('member/editProfile.html.twig', [
            'form' => $form->createView(),
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
