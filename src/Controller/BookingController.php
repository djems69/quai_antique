<?php



namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Restaurant;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    #[Route('/reservation', name: 'app_booking')]
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        // Récupère l'objet utilisateur actuellement connecté
        $user = $this->getUser();
        // Récupère l'email de l'utilisateur
        $email = $user->getEmail();
        // Création d'une nouvelle instance de la classe Booking
        $booking = new Booking();
        // Création du formulaire en utilisant la classe BookingType et l'objet $booking comme données
        $form = $this->createForm(BookingType::class, $booking);
        // Traitement de la requête HTTP avec le formulaire
        $form->handleRequest($request);
        // Vérification si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'objet Restaurant associé à la réservation
            $restaurant = $this->entityManager
                ->getRepository(Restaurant::class)
                ->find(4);

            // Récupère l'objet Booking contenant les données du formulaire
            $booking = $form->getData();
            // Ajout du restaurant à l'objet Booking
            $booking->setManagement($restaurant);

            // Récupère le jour, l'heure et le nombre de places de la réservation
            $day = $booking->getDay();
            $hour = $booking->getHour();
            $seats = $booking->getSeats();

                if ($seats <= 0) {
                    // Si le nombre de places est inférieur ou égal à zéro, affiche un message d'erreur
                    $this->addFlash('danger', 'Le nombre de places doit être supérieur à zéro');
                } else {
                    // Récupère le nombre de places disponibles pour le jour et l'heure de la réservation
                    $availableSeats = $this->getAvailableSeats($day, $hour, $restaurant);

                    // Si le nombre de places demandées est disponible
                    if ($availableSeats >= $seats) {
                        // Enregistre l'email de l'utilisateur dans l'objet Booking
                        $booking->setEmail($email);
                        // Enregistre l'objet Booking en base de données
                        $this->entityManager->persist($booking);
                        $this->entityManager->flush();
                        // Ajout d'un message flash de succès avec le texte "Votre réservation a bien été prise en compte !"
                        $this->addFlash('success', 'Votre réservation a bien été prise en compte !');
                        // Redirection vers la route "account"
                        return $this->redirectToRoute('account');
                    // Ajout d'un message flash d'erreur avec le texte "Il n'y a pas assez de places disponibles pour votre réservation."
                    } else {
                        $this->addFlash('danger', 'Il n\'y a pas assez de places disponibles pour votre réservation.');
                    }
                }
            }

        // Rendu de la vue Twig 'booking/index.html.twig' en passant le formulaire comme variable 'form'
        return $this->render('booking/index.html.twig', [
            'form' => $form
        ]);
    }


    private
    function getAvailableSeats(\DateTimeInterface $day, \DateTimeInterface $hour, Restaurant $restaurant): int
    {
        // Récupère les réservations pour le jour et l'heure donnés
        $bookings = $this->entityManager
            ->getRepository(Booking::class)
            ->findBy(['day' => $day, 'hour' => $hour, 'Management' => $restaurant]);

        // Calcule le nombre de places prises en comptant toutes les réservations
        $takenSeats = array_reduce($bookings, function (int $total, Booking $booking) {
            return $total + $booking->getSeats();
        }, 0);

        // Renvoie le nombre de places disponibles en soustrayant le nombre de places prises au nombre total de places
        return $restaurant->getCapacity() - $takenSeats;


    }
}

