<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut du projet',
                'choices' => [
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                    'En attente' => 'En attente',
                ],
                'placeholder' => 'Sélectionnez un statut',
                'required' => false,
            ])
            ->add('deadline', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date limite (Deadline)',
                'required' => false,
            ])
            ->add('membres', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'email',
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'label' => 'Sélectionne des membres',
                'attr' => [
                    'class' => 'select2',
                    'data-placeholder' => 'Sélectionne des membres...',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
