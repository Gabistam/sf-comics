<?php

namespace App\Form;

use App\Entity\Comics;
use App\Entity\Writer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComicsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('year')
            ->add('designer', EntityType::class, [
                'class' => Designer::class,
                'choice_label' => 'name'
            ])
            ->add('writer', EntityType::class, [
                'class' => Writer::class,
                'choice_label' => 'name'
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'name'
            ])
            ->add('licence', EntityType::class, [
                'class' => Licence::class,
                'choice_label' => 'name'
            ])


            ->add('Soumettre', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comics::class,
        ]);
    }
}