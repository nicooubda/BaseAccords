<?php

namespace App\Form;

use App\Entity\Accords;
use App\Entity\SousTypeDocument;
use App\Entity\TypeDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccordType extends AbstractType
{
    public function addFieldSousType(FormInterface $form, ?TypeDocument $typeDocument)
    {
        $form->getParent()->add('sousTypeDocument', EntityType::class, [
            'class' => SousTypeDocument::class,
            'placeholder' => $typeDocument ? 'Selectionner le sous type' : 'Selectionnerz d\'abord le type',
            'choice_label' => $typeDocument ? $typeDocument->getSousTypeDocument() : [],
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cote')
            ->add('boiteArchive')
            ->add('dateSignature_at')
            ->add('dateEntree_at')
            ->add('lieuSignature')
            ->add('etatAccord')
            ->add('intitule')
            ->add('motCle', TextareaType::class)
            ->add('motGeo', TextareaType::class)
            ->add('note')
            ->add('resume', TextareaType::class)
            ->add('typeDocument', EntityType::class, [
                'class' => TypeDocument::class,
                'choice_label' => 'type',
                'mapped' => false,
                'placeholder' => 'Sélectionnez le type de document',
            ])

            ;

        $builder->get('typeDocument')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                //$form->getParent()->addFieldSousType($form->getParent(), $form->getData());
                $form->getParent()->add('sousTypeDocument', EntityType::class, [
                    'class' => SousTypeDocument::class,
                    'placeholder' => 'Sélectionnez d\'abord le type',
                    'choices' => ($form->getData()) ? ($form->getData())->getSousTypeDocument() : [],
                ]);
            }
        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $sousType = $data->getSousTypeDocument();
                $form = $event->getForm();

                if ($sousType != null) {
                    $form->add('sousTypeDocument', EntityType::class, [
                        'class' => SousTypeDocument::class,
                        'placeholder' => 'Sélectionnez d\'abord le type',
                        'choices' => [],
                    ]);
                } else {
                    $form->add('sousTypeDocument', EntityType::class, [
                        'class' => SousTypeDocument::class,
                        'placeholder' => 'Sélectionnez d\'abord le type',
                        'choices' => [],
                    ]);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accords::class,
        ]);
    }
}
