<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('statut', TextType::class)
            // Champ date sans heure
            ->add('deadline', DateType::class, [
                'widget' => 'single_text', // Utilise un champ de saisie unique
                'attr' => [
                    'class' => 'form-control datepicker', // Ajoute une classe pour un éventuel datepicker
                    'placeholder' => 'Choisir une date',
                ],
                'required' => false, // La deadline est optionnelle
                'format' => 'yyyy-MM-dd', // Formater la date au format 'yyyy-MM-dd'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter la tâche',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}