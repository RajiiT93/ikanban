<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Activite;
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
    public function index(ProjetRepository $projetRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('connexion');
        }

        $projetsCrees = $projetRepository->findBy(['utilisateur' => $user]);

        $projetsInvites = $projetRepository->createQueryBuilder('p')
            ->join('p.membres', 'm')
            ->where('m.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();

        $projets = array_merge($projetsCrees, $projetsInvites);

        $activites = $em->getRepository(Activite::class)
            ->createQueryBuilder('a')
            ->where('a.projet IN (:projets)')
            ->setParameter('projets', $projets)
            ->orderBy('a.dateAction', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('projet/index.html.twig', [
            'projetsCrees' => $projetsCrees,
            'projetsInvites' => $projetsInvites,
            'activites' => $activites,
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

            $this->addActivite($em, 'Création du projet', $projet);

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

            $this->addActivite($em, 'Modification du projet', $projet);

            $this->addFlash('success', 'Projet modifié avec succès ✏️');
            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/edit.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}', name: 'projet_show', methods: ['GET'])]
    public function show(Projet $projet, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        if ($user !== $projet->getUtilisateur() && !$projet->getMembres()->contains($user)) {
            $this->addFlash('danger', "Tu n'as pas accès à ce projet.");
            return $this->redirectToRoute('projet_index');
        }

        $activitesTaches = $em->getRepository(Activite::class)
            ->createQueryBuilder('a')
            ->where('a.projet = :projet')
            ->andWhere('a.typeAction LIKE :type')
            ->setParameter('projet', $projet)
            ->setParameter('type', '%tâche%')
            ->orderBy('a.dateAction', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
            'activitesTaches' => $activitesTaches,
        ]);
    }

    #[Route('/{id}/delete', name: 'projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($this->getUser() !== $projet->getUtilisateur()) {
            $this->addFlash('danger', "Tu n'as pas le droit de supprimer ce projet.");
            return $this->redirectToRoute('projet_index');
        }

        if ($this->isCsrfTokenValid('delete' . $projet->getId(), $request->request->get('_token'))) {
            $this->addActivite($em, 'Suppression du projet', $projet);

            $em->remove($projet);
            $em->flush();

            $this->addFlash('success', 'Projet supprimé avec succès 🗑️');
        }

        return $this->redirectToRoute('projet_index');
    }

    // ✅ Fonction privée pour factoriser les créations d'activités
    private function addActivite(EntityManagerInterface $em, string $type, Projet $projet): void
    {
        $activite = new Activite();
        $activite->setTypeAction($type);
        $activite->setDateAction(new \DateTimeImmutable());
        $activite->setUtilisateur($this->getUser());
        $activite->setProjet($projet);

        $em->persist($activite);
        $em->flush();
    }
}
