<?php

namespace App\Form;

use App\Entity\Langue;
use App\Entity\AccordSearch;
use App\Entity\SousTypeDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccordSearchType extends AbstractType
{
    /* @var integer
     * @Assert\Range(
     *      min = 1960,
     *      max = 2050)
     */
    public $annee;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $annee = array();
        for ($i = 1960; $i <= 2050; ++$i) {
            $annee[$i] = $i;
        }
        $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre',
                ],
            ])
            ->add('type', EntityType::class, [
                'class' => SousTypeDocument::class,
                'choice_label' => 'sousType',
                'label' => false,
                'required' => false,
                'placeholder' => 'Sélectionnez le sous type du document',
            ])
            ->add('langue', EntityType::class, [
                'class' => Langue::class,
                'choice_label' => 'langue',
                'required' => false,
                'label' => false,
                'placeholder' => 'Sélectionnez la langue',
            ])
            ->add('lieu', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lieu',
                ],
            ])
            ->add('resume', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Résume',
                ],
            ])
            ->add('motCle', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Mot clé',
                ],
            ])
            ->add('dates', ChoiceType::class, [
                'choices' => $annee,
                'placeholder' => 'Sélectionnez l\'année',
                'label' => false,
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AccordSearch::class,
            'method' => 'get',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
