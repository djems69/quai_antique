<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=>'Nom'
                ])
                ->add('day', DateTimeType::class, [
                    'placeholder' => [
                        'day' => 'Jour',
                        'month' => 'Mois',
                        'year' => 'Année',
                        'hour' => 'Heure',
                        'minute' => 'Minutes'
                    ],
                ])
                /*->add('hour', TimeType::class, [
                    'label'=>'heure',
                    'input' => 'datetime',
                    'widget' => 'choice',
                    'hours' => [11, 12, 13, 18, 19, 20, 21],
                    'minutes' => [00, 15, 30, 45],
                    ])*/

            ->add('allergy', TextType::class, [
                'label' => 'Allergies',
                'attr' => [
                    'placeholder' => 'Veuillez indiquer si vous avez des allergies ou des intolérances alimentaires.'
               ]
                ])
            ->add('seats', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'attr' => ['min' => 1, 'max' => 10]
                ])
            ->add('save', SubmitType::class, ['label' => 'Réserver'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
