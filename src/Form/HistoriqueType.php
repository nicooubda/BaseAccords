<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('table', ChoiceType::class, [
                'choices' => [
                    'Accord' => 'Accords',
                    'Langue' => 'Langue',
                    'Repertoire' => 'Repertoire',
                    'SousTypeDocument' => 'Sous Type Document',
                    'Type' => 'Type',
                    'Users' => 'User',
                ],
            ])
            ->add('action', ChoiceType::class, [
                'choices' => [
                    'insert' => 'INSERT',
                    'update' => 'UPDATE',
                    'delete' => 'DELETE',
                ],
            ])
            ->add('date', TypeDateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
