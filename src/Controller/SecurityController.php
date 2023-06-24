<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Vérification si l'utilisateur est déjà connecté
        if ($this->getUser()) {
            // Redirection vers la route 'account' si l'utilisateur est déjà connecté

            return $this->redirectToRoute('account');
        }

        // Récupération de la dernière erreur d'authentification
        $error = $authenticationUtils->getLastAuthenticationError();
        // Récupération du dernier nom d'utilisateur utilisé lors de la tentative d'authentification
        $lastUsername = $authenticationUtils->getLastUsername();

        // Rendu de la vue Twig 'security/login.html.twig' avec les variables 'last_username' et 'error'
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
