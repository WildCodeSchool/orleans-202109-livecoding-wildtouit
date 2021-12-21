<?php

namespace App\Controller;

use App\Entity\Touit;
use App\Form\TouitType;
use App\Repository\TouitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/touit")
 */
class TouitController extends AbstractController
{
    /**
     * @Route("/", name="touit_index", methods={"GET"})
     */
    public function index(TouitRepository $touitRepository): Response
    {
        return $this->render('touit/index.html.twig', [
            'touits' => $touitRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="touit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $touit = new Touit();
        $form = $this->createForm(TouitType::class, $touit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($touit);
            $entityManager->flush();

            return $this->redirectToRoute('touit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('touit/new.html.twig', [
            'touit' => $touit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="touit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Touit $touit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TouitType::class, $touit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('touit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('touit/edit.html.twig', [
            'touit' => $touit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="touit_delete", methods={"POST"})
     */
    public function delete(Request $request, Touit $touit, EntityManagerInterface $entityManager): Response
    {
        /** @var string|null */
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $touit->getId(), $token)) {
            $entityManager->remove($touit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('touit_index', [], Response::HTTP_SEE_OTHER);
    }
}
