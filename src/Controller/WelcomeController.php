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
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('connexion');
        }

        $projets = $projetRepository->findBy(['utilisateur' => $user]);

        return $this->render('projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }
}
