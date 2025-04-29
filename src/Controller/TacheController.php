<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Entity\Projet;
use App\Entity\Activite;
use App\Form\TacheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TacheController extends AbstractController
{
    #[Route('/projet/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        if ($user !== $projet->getUtilisateur() && !$projet->getMembres()->contains($user)) {
            $this->addFlash('danger', "Tu n'as pas accès à ce projet.");
            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/tache/new/{idProjet}', name: 'tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, int $idProjet): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $projet = $em->getRepository(Projet::class)->find($idProjet);

        if (!$projet) {
            throw $this->createNotFoundException('Projet introuvable.');
        }

        $tache = new Tache();
        $tache->setProjet($projet);

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tache);
            $em->flush();

            // ✅ Historique détaillé : tâche + projet
            $this->addActivite($em, $projet, $tache, sprintf('Création de la tâche "%s"', $tache->getTitre()));

            $this->addFlash('success', 'Tâche ajoutée avec succès ✅');
            return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()]);
        }

        return $this->render('tache/new.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet,
        ]);
    }

    /**
     * ✅ Crée une activité liée au projet et éventuellement à la tâche.
     */
    private function addActivite(EntityManagerInterface $em, Projet $projet, ?Tache $tache, string $typeAction): void
    {
        $activite = new Activite();
        $activite->setTypeAction($typeAction);
        $activite->setDateAction(new \DateTimeImmutable());
        $activite->setUtilisateur($this->getUser());
        $activite->setProjet($projet);
        $activite->setTache($tache);

        $em->persist($activite);
        $em->flush();
    }
}
