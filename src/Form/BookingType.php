<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;


class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupère l'email de l'utilisateur connecté à partir du service Security.
        $email = $this->security->getUser()->getEmail();
        $builder
            // Ajoute un champ caché pour l'email avec la valeur déterminée ci-dessus.
            ->add('email', HiddenType::class, [
                'label'=>'Mail',
                'data'=>$email
                ])
            // Ajoute un champ de type DateType pour la date de la réservation.
                ->add('day', DateType::class, [
                    'label'=>'Jour',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'model_timezone' => 'Europe/Paris',
                ])
            // Ajoute un champ de type TimeType pour l'heure de la réservation.
                ->add('hour', TimeType::class, [
                    'label'=>'heure',
                    'input' => 'datetime',
                    'widget' => 'choice',
                    'hours' => [11, 12, 13, 14, 15, 18, 19, 20, 21, 22],
                    'minutes' => [00, 15, 30, 45],
                    ])
            // Ajoute un champ de type TextType pour les allergies ou intolérances alimentaires.
            ->add('allergy', TextType::class, [
                'label' => 'Allergies',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Veuillez indiquer si vous avez des allergies ou des intolérances alimentaires.'
               ]
                ])
            // Ajout d'un champ pour le nombre de personnes dans la réservation
            ->add('seats', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'attr' => ['min' => 1, 'max' => 10]
                ])
            // Ajout d'un bouton pour soumettre la réservation
            ->add('save', SubmitType::class, ['label' => 'Réserver'])
        ;
    }

    // Déclaration de la variable de sécurité
    private $security;

    // Constructeur qui prend en entrée un objet de sécurité
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // Configuration des options par défaut pour la classe de réservation
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
