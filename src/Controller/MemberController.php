<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use App\Service\AddressService;
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

    public function lastMembers(UserRepository $userRepository, int $max = 3): Response
    {
        return $this->render('member/_last_users.html.twig', [
            'lastUsers' => $userRepository->findBy([], null, $max),
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
    public function editProfile(
        Request $request,
        EntityManagerInterface $entityManager,
        AddressService $addressService
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            if ($user->getCity() !== null) {
                $coordinates = $addressService->getCoordinates($user->getCity());
                $user->setLatitude($coordinates[0]);
                $user->setLongitude($coordinates[1]);
            }
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a bien été édité');

            return $this->redirectToRoute('member_profile');
        }

        return $this->render('member/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/member/follow/{user}", name="member_follow", methods={"POST"})
     * @isGranted("ROLE_USER");
     */
    public function toggleFollow(User $user, EntityManagerInterface $entityManager): Response
    {
        /** @var User */
        $connectedUser = $this->getUser();
        if ($user->getFollowers()->contains($connectedUser)) {
            $connectedUser->removeFollowedUser($user);
        } else {
            $connectedUser->addFollowedUser($user);
        }
        $entityManager->flush();

        return $this->redirectToRoute('member');
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
