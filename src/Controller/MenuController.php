<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Menu;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/menus', name: 'menus')]
    public function index(): Response
    {
        $menus = $this->entityManager->getRepository(Menu::class)->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
            'form' => $form->createView()
        ]);
    }


    #[Route('/nos-menus/{slug}', name: 'nos-menus')]
        public function show($slug): Response
    {
        $menu = $this->entityManager->getRepository(Menu::class)->findOneBySlug($slug);

        if (!$menu) {
            return $this->redirectToRoute('menus');
        }

        return $this->render('menu/show.html.twig', [
            'menu' => $menu
        ]);
    }
}
