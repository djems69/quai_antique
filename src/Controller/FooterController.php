<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{

    #[Route('/footer', name: 'app_footer')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupération du restaurant à afficher
        $restaurant = $entityManager
            ->getRepository(Restaurant::class)
            ->find(4);

        // Envoi des informations sur les horaires d'ouverture et de fermeture à la vue
        return $this->render('footer/index.html.twig', [
            'openingTime' => $restaurant->getOpeningTime(),
            'closingTime' => $restaurant->getClosingTime(),
            'openingTimeNoon' => $restaurant->getOpeningTimeNoon(),
            'closingTimeNoon' => $restaurant->getClosingTimeNoon(),

        ]);
    }

}
