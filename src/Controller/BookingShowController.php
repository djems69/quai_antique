<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingShowController extends AbstractController
{
    #[Route('/mes-reservations', name: 'booking_show')]
    public function index(): Response
    {

        $booking = new Booking();


        return $this->render('booking_show/index.html.twig', [
            'booking' => $booking
        ]);
    }
}
