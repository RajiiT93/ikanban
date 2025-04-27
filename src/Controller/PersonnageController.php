<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnageController extends AbstractController
{
    #[Route('/personnage', name: 'app_personnage')] // 🔥 changé ici
    public function index(): Response
    {
        return $this->render('personnage/index.html.twig', [
        ]);
    }

    #[Route('/perso', name: 'app_perso')]
    public function index2(): Response
    {
        return $this->render('personnage/perso.html.twig', [
        ]);
    }
}
