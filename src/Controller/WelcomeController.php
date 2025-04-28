<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(ProjetRepository $projetRepository): Response
    {
        // Vérifier si la session est démarrée, sinon la démarrer
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Démarrer la session si nécessaire
        }

        // Vous pouvez également régénérer l'ID de la session si nécessaire
        session_regenerate_id(true); // Cela régénère l'ID de session

        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        if (!$user) {
            return $this->redirectToRoute('connexion');
        }

        // Récupérer les projets créés par l'utilisateur
        $projetsCrees = $projetRepository->findBy(['utilisateur' => $user]);

        // Récupérer les projets où l'utilisateur est invité
        $projetsInvites = $projetRepository->findProjetsOuUtilisateurEstInvite($user);

        // Passer les variables au template
        return $this->render('projet/index.html.twig', [
            'projetsCrees' => $projetsCrees,   // Projets créés par l'utilisateur
            'projetsInvites' => $projetsInvites, // Projets où l'utilisateur est invité
        ]);
    }
}
