<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', TextType::class, [
                'required' => false,
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'À faire' => 'À faire',
                    'En cours' => 'En cours',
                    'Terminé' => 'Terminé',
                ],
                'placeholder' => 'Sélectionner un statut',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('deadline', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Choisir une date',
                ],
                'required' => false,
                'format' => 'yyyy-MM-dd',
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
