<?php

namespace App\Form;

use App\Entity\Accords;
use App\Entity\Langue;
use App\Entity\Repertoire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RepertoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repertoire', FileType::class, [
                'label' => 'Accord (Fichhier PDF)',

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Telecharger un fichier au format pdf',
                    ]),
                ],
            ])

            ->add('langue', EntityType::class, [
                'class' => Langue::class,
                'choice_label' => 'langue',
                'placeholder' => 'Sélectionnez la langue',
            ])
            ->add('accord', EntityType::class, [
                'class' => Accords::class,
                'choice_label' => 'cote',
                'placeholder' => 'Sélectionnez la l\'accord',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repertoire::class,
        ]);
    }
}
