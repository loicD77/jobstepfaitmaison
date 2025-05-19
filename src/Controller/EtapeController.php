<?php

namespace App\Controller;

use App\Entity\Etape;
use App\Form\EtapeForm;
use App\Repository\EtapeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etape')]
final class EtapeController extends AbstractController
{
    // ✅ Affiche toutes les étapes (admin ou conseiller)
    #[Route('', name: 'app_etape_index', methods: ['GET'])]
    public function index(EtapeRepository $etapeRepository): Response
    {
        return $this->render('etape/index.html.twig', [
            'etapes' => $etapeRepository->findAll(),
        ]);
    }

    // ✅ Création d'une nouvelle étape
    #[Route('/new', name: 'app_etape_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
    
        // On récupère le parcours du user connecté
        $parcours = $user?->getParcours()->first();
    
        if (!$parcours) {
            $this->addFlash('warning', 'Vous devez d’abord créer un parcours avant d’ajouter des étapes.');
            return $this->redirectToRoute('app_parcours_new');
        }
    
        $etape = new Etape();
        $etape->setParcours($parcours); // ✅ association automatique
    
        $form = $this->createForm(EtapeForm::class, $etape);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etape);
            $entityManager->flush();
    
            return $this->redirectToRoute('parcours_etapes');
        }
    
        return $this->render('etape/new.html.twig', [
            'etape' => $etape,
            'form' => $form,
        ]);
    }
    

    // ✅ Page personnalisée : étapes du parcours du user connecté
    #[Route('/mon-parcours', name: 'parcours_etapes', methods: ['GET'])]
    public function monParcours(EtapeRepository $etapeRepository): Response
    {
        $user = $this->getUser();
        $parcours = $user?->getParcours()->first(); // ⚠️ nécessite la méthode getParcours() sur User

        $etapes = $parcours ? $parcours->getEtapes() : [];

        return $this->render('parcours/etapes.html.twig', [
            'etapes' => $etapes,
            'renduForms' => [], // à compléter si tu ajoutes l’upload
        ]);
    }

    // ✅ Modification d'une étape existante
    #[Route('/{id}/edit', name: 'app_etape_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etape $etape, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtapeForm::class, $etape);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etape_index');
        }

        return $this->render('etape/edit.html.twig', [
            'etape' => $etape,
            'form' => $form,
        ]);
    }

    // ✅ Suppression d'une étape
    #[Route('/{id}/delete', name: 'app_etape_delete', methods: ['POST'])]
    public function delete(Request $request, Etape $etape, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $etape->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etape);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etape_index');
    }

    // ✅ Affichage d'une étape spécifique par ID
    #[Route('/{id<\d+>}', name: 'app_etape_show', methods: ['GET'])]
    public function show(Etape $etape): Response
    {
        return $this->render('etape/show.html.twig', [
            'etape' => $etape,
        ]);
    }
}
