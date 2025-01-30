<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', IntegerType::class, [
                'label' => 'Note (1 à 5)',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez donner une note.']),
                    new Range([
                        'min' => 1,
                        'max' => 5,
                        'notInRangeMessage' => 'La note doit être comprise entre 1 et 5.',
                    ]),
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Votre avis',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un commentaire.']),
                ],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'Partagez votre expérience...'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
