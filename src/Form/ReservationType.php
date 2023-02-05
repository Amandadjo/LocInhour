<?php

namespace App\Form;


use App\Entity\Reservation;
use App\Entity\Voitures;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => "Prénom",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre prénom'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => "Nom",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom'
                    ])
                ]
            ])
            ->add('numeroPermis', IntegerType::class, [
                'required' => true,
                'label' => "Numéro de permis",
                'constraints' => [
                  new NotBlank([
                    'message' => 'Veuillez saisir votre numéro de permis'
                  ]),
                  new Length([
                    'min' => 12,
                    'minMessage' => 'Le numéro de permis doit contenir au minimum {{ limit }} caractères'
                  ]),
                ]
              ])
            ->add('dateReservation', DateTimeType::class, [
                'required' => true,
                'data' => new \DateTimeImmutable(),
                'label' => "Date de réservation",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre date et heure de réservation'
                    ])
                ]
            ])
            ->add('finReservation', DateTimeType::class, [
                'required' => true,
                'data' => new \DateTimeImmutable(),
                'label' => "Date de fin de réservation",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre votre date et heure de fin de réservation'
                    ])
                ]
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => "Pièce d'identité",
                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez télécharger la copie de votre piède d'identité"
                    ])
                ]
            ])
            
            // ->add('imageFile', FileType::class, [
            //     'required' => true,
            //     'label' => "Permis de conduire",
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Veuillez télécharger la copie de votre permis'
            //         ])
            //     ]
            // ])
       
            // ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
