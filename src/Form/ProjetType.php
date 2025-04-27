<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType; // ✅ On ajoute l'import DateType
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du projet',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('statut', TextType::class, [
                'label' => 'Statut',
            ])
            ->add('deadline', DateType::class, [ // ✅ Utiliser DateType
                'widget' => 'single_text',      // ✅ Pour avoir un champ <input type="date">
                'label' => 'Date limite',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
