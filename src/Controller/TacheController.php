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

#[Route('/tache')]
class TacheController extends AbstractController
{
    #[Route('/new/{idProjet}', name: 'tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, int $idProjet): Response
    {
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

            $this->addFlash('success', 'Tâche ajoutée avec succès ✅');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('tache/new.html.twig', [
            'form' => $form->createView(),
            'projet' => $projet,
        ]);
    }
}
