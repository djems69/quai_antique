<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BookingShowController extends AbstractController
{
    // Déclaration de la propriété de type EntityManagerInterface
    private $entityManager;

    // Définition du constructeur pour injecter EntityManager dans la classe
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;

    }
    // Déclaration de la route "/mes-reservations"
    #[Route('/mes-reservations', name: 'booking_show')]
    // La méthode "index" pour afficher les réservations de l'utilisateur connecté
    public function index(): Response
    {
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        // Récupération de l'adresse email de l'utilisateur connecté
        $email = $user->getEmail();

        // Récupération des réservations de l'utilisateur connecté via une requête Doctrine
        $bookings = $this->entityManager->createQuery(
            'SELECT b
            FROM App:Booking b
            WHERE b.email = :email'
        )->setParameter('email', $email)
            ->getResult();

        // Affichage de la vue twig "index.html.twig" avec les réservations passées en paramètre
        return $this->render('booking_show/index.html.twig', [
            'bookings' => $bookings
        ]);
    }
}
