<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecuController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setMotDePasse(
                $passwordHasher->hashPassword($utilisateur, $utilisateur->getMotDePasse())
            );
            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success', 'Inscription réussie ! Vous pouvez vous connecter ✅');

            return $this->redirectToRoute('connexion');
        }

        return $this->render('admin_secu/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/connexion', name: 'connexion')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('admin_secu/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // Symfony gère automatiquement la déconnexion ici
    }
}
