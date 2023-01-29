<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    # Déclaration de la propriété entityManager
    private $entityManager;

    # Constructeur qui initialise la propriété entityManager
    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    # Définition de la route '/compte/modification-mot-de-passe'
    #[Route('/compte/modification-mot-de-passe', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        # Récupération de l'utilisateur connecté
        $user = $this->getUser();
        # Création du formulaire de modification de mot de passe en utilisant la classe ChangePasswordType
        $form = $this->createForm(ChangePasswordType::class, $user);

        # Traitement de la requête HTTP
        $form->handleRequest($request);

        # Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            # Récupération du mot de passe actuel saisi dans le formulaire
            $old_pwd = $form->get('old_password')->getData();

            # Vérification que le mot de passe actuel est correct
            if ($hasher->isPasswordValid($user, $old_pwd)) {
                # Récupération du nouveau mot de passe saisi dans le formulaire
                $new_pwd = $form->get('new_password')->getData();
                # Hachage du nouveau mot de passe
                $password = $hasher->hashPassword($user, $new_pwd);

                # Mise à jour du mot de passe de l'utilisateur
                $user->setPassword($password);
                # Enregistrement des modifications dans la base de données
                $this->entityManager->flush();
                # Affichage d'un message de succès
                $this->addFlash('success', 'Votre mot de passe a bien été modifié.');
                # Redirection vers la page de compte
                return $this->redirectToRoute('account');

            } else {
                // Message d'erreur si le mot de passe actuel entré n'est pas valide
                $this->addFlash('danger',"Votre mot de passe actuel n'est pas le bon.");
            }
        }

        // Rendre la vue Twig 'account/password.html.twig' avec le formulaire
        return $this->render('account/password.html.twig', [
            'form' => $form,
        ]);
    }
}
