<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    // Déclaration de la propriété privée $entityManager
    private $entityManager;

    // Constructeur de la classe qui reçoit une instance de l'interface EntityManagerInterface et l'assigne à la propriété $entityManager
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    // Définition de la route '/inscription' avec le nom 'register'
    #[Route('/inscription', name: 'register')]
    // Méthode index qui correspond à la route '/inscription' et prend en paramètre un objet Request et une instance de l'interface UserPasswordHasherInterface
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        // Instanciation d'un objet de la classe User
        $user = new User();
        // Création d'un formulaire à partir de la classe RegisterType et de l'objet $user
        $form = $this->createForm(RegisterType::class, $user);
        // Gestion de la soumission du formulaire
        $form->handleRequest($request);

        // Vérification de la validation du formulaire
        if($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            $user=$form->getData();
            // Hachage du mot de passe de l'utilisateur
            $password = $hasher->hashPassword($user,$user->getPassword());
            $user->setPassword($password);
            // Enregistrement de l'utilisateur en base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // Affichage d'un message de succès
            $this->addFlash('success', 'Votre compte a été créé avec succès !');
            // Redirection vers la route "account"
            return $this->redirectToRoute('account');
        }
        // Retourne la vue register/index.html.twig avec le formulaire créé
        return $this->render('register/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
