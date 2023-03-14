<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/nous-contacter', name: 'contact')]
    public function index(Request $request): Response
    {
        # Creation d'un formulaire de type ContactType
        $form = $this->createForm(ContactType::class);
        # handleRequest permet de traiter la requête HTTP
        $form->handleRequest($request);

        # Si le formulaire a été soumis et est valide
        if($form->isSubmitted() && $form->isValid()) {
            # Ajout d'un message flash de succès
            $this->addFlash('success', 'Merci de nous avoir contacté! Notre équipe vous répondra dans les meilleurs délais.');
        }

        # Renvoi de la vue associée au formulaire
        return $this->render('contact/index.html.twig', [
            'form' => $form
        ]);
    }
}
