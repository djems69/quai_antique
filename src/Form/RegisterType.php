<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label'=>'Votre prenom',
                'constraints'=> new Length([
                    'min'=> 3,
                    'max'=> 30
                ]),
                'attr'=> [
                    'placeholder'=>'Saisissez votre prenom'
            ]
            ])
            ->add('lastname', TextType::class, [
                'label'=>'Votre nom',
                'constraints'=> new Length([
                    'min'=> 3,
                    'max'=> 30
                ]),
                'attr'=> [
                    'placeholder'=>'Saisissez votre nom'
    ]
            ])
            ->add('email', EmailType::class, [
                'label'=>'Votre email',
                'constraints'=> new Length([
                    'min'=> 3,
                    'max'=> 50
                ]),
                'attr'=> [
                    'placeholder'=>'Saisissez votre email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'invalid_message'=>'Le mot de passe et la confirmation doivent etre identiques',
                'label'=>'Votre mot de passe',
                'required'=>true,
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                        "Il faut un mot de passe de 8 caractère avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial")
                ],
                'first_options'=> [
                    'label'=>'Mot de passe',
                    'attr'=> [
                        'placeholder'=>'Saisissez votre mot de passe'
                    ]
                    ],
                'second_options'=> [
                    'label'=>'Confirmez votre mot de passe',
                    'attr'=> [
                        'placeholder'=>'Confirmez votre mot de passe'
                    ],
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>"S'inscrire"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
