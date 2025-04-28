<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Utilisateur; // 👈 Ajout de l'import
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // 👈 Import pour EntityType
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du projet',
                'attr' => ['placeholder' => 'Entrez le nom du projet'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du projet',
                'required' => false,
                'attr' => ['placeholder' => 'Décrivez le projet...'],
            ])
            ->add('statut', TextType::class, [
                'label' => 'Statut',
                'attr' => ['placeholder' => 'Par ex: En cours, Terminé, À faire'],
                'required' => false,
            ])
            ->add('deadline', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date limite (Deadline)',
                'required' => false,
            ])
            ->add('membres', EntityType::class, [ // 🔥 Champ pour inviter des membres
                'class' => Utilisateur::class,
                'choice_label' => 'email', // ou 'nom' si tu préfères
                'multiple' => true,
                'expanded' => true, // checkbox si true, sinon select multiple
                'required' => false,
                'label' => 'Inviter des membres au projet',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
