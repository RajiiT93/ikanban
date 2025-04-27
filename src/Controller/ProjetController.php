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

        $projets = $projetRepository->findBy(['utilisateur' => $user]);

        return $this->render('projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/new', name: 'projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('connexion');
        }

        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setUtilisateur($user);
            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', 'Projet créé avec succès ✅');
            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/new.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet, // ✅ ajouté ici 🔥
        ]);
    }

    #[Route('/{id}/edit', name: 'projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

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

    #[Route('/{id}', name: 'projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $em->remove($projet);
            $em->flush();

            $this->addFlash('success', 'Projet supprimé avec succès 🗑️');
        }

        return $this->redirectToRoute('projet_index');
    }
}
