<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\Projet;
use App\Form\TacheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TacheController extends AbstractController
{
    // Affiche le projet et ses tâches, et permet d'ajouter une nouvelle tâche
    #[Route('/projet/{id}', name: 'app_projet_show')]
    public function show(Projet $projet, Request $request, EntityManagerInterface $em): Response
    {
        // Créer une nouvelle tâche pour ce projet
        $tache = new Tache();
        $tache->setProjet($projet); // Associer la tâche au projet

        // Créer le formulaire pour ajouter la tâche
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer la tâche
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tache);  // Sauvegarder la tâche
            $em->flush();          // Exécuter la requête en base de données

            // Ajouter un message flash pour informer que la tâche a été ajoutée avec succès
            $this->addFlash('success', 'Tâche ajoutée avec succès ✅');

            // Rediriger vers la même page pour afficher la tâche ajoutée
            return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
        }

        // Récupérer les tâches existantes liées à ce projet
        $taches = $projet->getTaches();

        // Rendre la vue avec le projet, le formulaire et les tâches associées
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),  // Afficher le formulaire de tâche
            'taches' => $taches,            // Afficher les tâches existantes
        ]);
    }

    // Créer une nouvelle tâche via un formulaire
    #[Route('/tache/new/{idProjet}', name: 'tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, int $idProjet): Response
    {
        // Récupérer le projet via l'ID passé dans l'URL
        $projet = $em->getRepository(Projet::class)->find($idProjet);

        if (!$projet) {
            throw $this->createNotFoundException('Projet introuvable.');
        }

        // Créer une nouvelle tâche
        $tache = new Tache();
        $tache->setProjet($projet); // Associer cette tâche au projet

        // Créer le formulaire pour la nouvelle tâche
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer la tâche
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tache);  // Sauvegarder la tâche
            $em->flush();          // Exécuter la requête en base de données

            // Ajouter un message flash pour informer que la tâche a été ajoutée avec succès
            $this->addFlash('success', 'Tâche ajoutée avec succès ✅');

            // Rediriger vers la vue du projet avec la nouvelle tâche ajoutée
            return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
        }

        // Rendre la vue du formulaire d'ajout de tâche
        return $this->render('tache/new.html.twig', [
            'form' => $form->createView(),  // Afficher le formulaire de tâche
            'projet' => $projet,            // Afficher les détails du projet
        ]);
    }
}
