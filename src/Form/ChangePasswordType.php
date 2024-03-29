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
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label'=> 'Mon adresse email'
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prenom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'mapped' => false,
                'invalid_message'=>'Le mot de passe et la confirmation doivent etre identiques',
                'label'=>'Mon nouveau mot de passe',
                'required'=>true,
                'constraints' => [
                    new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                        "Il faut un mot de passe de 8 caractère avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial")
                ],
                'first_options'=> [
                    'label'=>'Mon nouveau mot de passe',
                    'attr'=> [
                        'placeholder'=>'Saisissez votre nouveau mot de passe'
                    ]
                ],
                'second_options'=> [
                    'label'=>'Confirmez votre mot de passe',
                    'attr'=> [
                        'placeholder'=>'Confirmez votre nouveau mot de passe'
                    ],
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>"Mettre a jour"
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
