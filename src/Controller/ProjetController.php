<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    #[Route('/', name: 'projet_index', methods: ['GET'])]
    public function index(ProjetRepository $projetRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('connexion');
        }

        // Récupération des projets créés par l'utilisateur
        $projetsCrees = $projetRepository->findBy(['utilisateur' => $user]);

        // Récupération des projets où l'utilisateur est membre invité
        $projetsInvites = $projetRepository->createQueryBuilder('p')
            ->join('p.membres', 'm')
            ->where('m.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();

        // Envoi des variables au template
        return $this->render('projet/index.html.twig', [
            'projetsCrees' => $projetsCrees,    // Projets créés par l'utilisateur
            'projetsInvites' => $projetsInvites,  // Projets où l'utilisateur est invité
        ]);
    }

    #[Route('/new', name: 'projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setUtilisateur($this->getUser());

            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', 'Projet créé avec succès ✅');
            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->getUser() !== $projet->getUtilisateur()) {
            $this->addFlash('danger', "Tu n'as pas le droit de modifier ce projet.");
            return $this->redirectToRoute('projet_index');
        }

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Projet modifié avec succès ✏️');
            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/edit.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}', name: 'projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/delete', name: 'projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Vérification que l'utilisateur est bien le créateur du projet
        if ($this->getUser() !== $projet->getUtilisateur()) {
            $this->addFlash('danger', "Tu n'as pas le droit de supprimer ce projet.");
            return $this->redirectToRoute('projet_index');
        }

        // Validation du token CSRF
        if ($this->isCsrfTokenValid('delete' . $projet->getId(), $request->request->get('_token'))) {
            $em->remove($projet);
            $em->flush();

            $this->addFlash('success', 'Projet supprimé avec succès 🗑️');
        }

        return $this->redirectToRoute('projet_index');
    }
}
