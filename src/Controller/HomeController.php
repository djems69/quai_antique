<?php

namespace App\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // Déclaration de la variable d'instance entityManager
    private $entityManager;

    // Constructeur pour injecter EntityManager
    public function __construct(EntityManagerInterface $entityManager)
    {
        // Initialisation de la variable d'instance entityManager
        $this->entityManager = $entityManager;
    }
    // Déclaration de la méthode index pour le traitement de la route "/"
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // Récupération de tous les menus avec l'attribut "isBest" égal à 1
        $menus = $this->entityManager->getRepository(Menu::class)->findByisBest(1);

        // Retourne la vue home/index.html.twig avec les menus trouvés
        return $this->render('home/index.html.twig', [
            'menus' => $menus
        ]);
    }
}
