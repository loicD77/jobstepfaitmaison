<?php

namespace App\Controller;

use App\Entity\Parcours;
use App\Form\ParcoursForm;
use App\Repository\ParcoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/parcours')]
final class ParcoursController extends AbstractController
{
    #[Route('/parcours', name: 'app_parcours_index')]
    public function index(ParcoursRepository $parcoursRepository, EtapeRepository $etapeRepository): Response
    {
        return $this->render('parcours/index.html.twig', [
            'parcours' => $parcoursRepository->findAll(),
            'etapes' => $etapeRepository->findAll(), // 👈 Ajout de la variable
        ]);
    }
    
    #[Route('/parcours/new', name: 'app_parcours_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $parcours = new Parcours();
        $form = $this->createForm(ParcoursForm::class, $parcours);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $parcours->setUser($this->getUser());
            $em->persist($parcours);
            $em->flush();
    
            return $this->redirectToRoute('app_parcours_index');
        }
    
        return $this->render('parcours/new.html.twig', [
            'form' => $form
        ]);
    }
    

    #[Route('/{id}', name: 'app_parcours_show', methods: ['GET'])]
    public function show(Parcours $parcour): Response
    {
        return $this->render('parcours/show.html.twig', [
            'parcour' => $parcour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parcours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parcours $parcour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParcoursForm::class, $parcour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parcours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parcours/edit.html.twig', [
            'parcour' => $parcour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parcours_delete', methods: ['POST'])]
    public function delete(Request $request, Parcours $parcour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parcour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($parcour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parcours_index', [], Response::HTTP_SEE_OTHER);
    }
}
