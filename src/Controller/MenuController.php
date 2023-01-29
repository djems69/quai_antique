<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Menu;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// Déclaration de la classe MenuController qui étend la classe AbstractController

class MenuController extends AbstractController
{
    // Déclaration de la variable d'instance entityManager
    private $entityManager;

    // Constructeur pour injecter EntityManager
    public function __construct(EntityManagerInterface $entityManager) {
        // Initialisation de la variable d'instance entityManager
        $this->entityManager = $entityManager;
    }


    // Déclaration de la méthode index pour le traitement de la route "/menus"
    #[Route('/menus', name: 'menus')]
    public function index(Request $request): Response
    {
        // Récupération de tous les menus
        $menus = $this->entityManager->getRepository(Menu::class)->findAll();
        // Création d'une instance de Search
        $search = new Search();
        // Création du formulaire de recherche à partir du type SearchType
        $form = $this->createForm(SearchType::class, $search);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des menus en utilisant la méthode findWithSearch avec les critères de recherche
            $menus = $this->entityManager->getRepository(Menu::class)->findWithSearch($search);
        }

        // Retourne la vue menu/index.html.twig avec les menus trouvés et le formulaire
        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
            'form' => $form->createView()
        ]);
    }

    // Déclaration de la méthode show pour le traitement de la route "/nos-menus/{slug}"
    #[Route('/nos-menus/{slug}', name: 'nos-menus')]
        public function show($slug): Response
    {
        // Récupération d'un menu avec le slug fourni
        $menu = $this->entityManager->getRepository(Menu::class)->findOneBySlug($slug);
        // Récupération de tous les menus avec l'attribut "isBest" égal à 1
        $menus = $this->entityManager->getRepository(Menu::class)->findByisBest(1);

        // Vérification si un menu n'a pas été trouvé
        if (!$menu) {
            // Redirection vers la route "menus"
            return $this->redirectToRoute('menus');
        }

        // Retourne la vue menu/show.html.twig avec le menu trouvé et les menus ayant l'attribut "isBest" égal à 1
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
            'menus' => $menus
        ]);
    }
}
