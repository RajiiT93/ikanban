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
use App\Entity\Groupe;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecuController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordCrypte = $passwordHasher->hashPassword(
                $utilisateur,
                $utilisateur->getMotDePasse()
            );
            $utilisateur->setMotDePasse($passwordCrypte);

            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute("accueil");
        }

        return $this->render('admin_secu/inscription.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'connexion')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("admin_secu/login.html.twig", [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // Cette méthode est vide : Symfony intercepte la route automatiquement
        throw new \Exception('Cette méthode peut rester vide, elle est interceptée par le firewall.');
    }

    #[Route('/init-groupes', name: 'init_groupes')]
    public function initGroupes(EntityManagerInterface $em): Response
    {
        $noms = ['Chef', 'Second', 'Employé', 'Stagiaire'];

        foreach ($noms as $nom) {
            $groupe = new Groupe();
            $groupe->setNom($nom);
            $groupe->setDescription("Rôle de type $nom");
            $groupe->setEstpublic(true);
            $groupe->setDatecreation(new \DateTime());
            $em->persist($groupe);
        }

        $em->flush();

        return new Response('Groupes ajoutés avec succès ✅');
    }
}
