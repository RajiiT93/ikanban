<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Groupe;  // Assure-toi que "Groupe" est bien l'entité que tu veux utiliser
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
// use Symfony\Component\Form\Extension\Core\Type\EntityType;  // Ajoute cette ligne ici
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('motDePasse',PasswordType::class)
            ->add('role')
          /*  ->add('photo') */
            ->add('service')
          /*  ->add('groupe', EntityType::class, [
                'class' => Groupe::class,  // Assure-toi que "Groupe" est la bonne entité
                'choice_label' => 'name',  // Le champ à afficher dans le formulaire
                'multiple' => true,        // Pour autoriser la sélection de plusieurs groupes
                'expanded' => false,       // Choix dans une liste déroulante
            ]) 
            */
            ->add('verifMotDePasse',PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
