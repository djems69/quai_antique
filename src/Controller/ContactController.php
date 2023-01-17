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
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Merci de nous avoir contacté! Notre équipe vous répondra dans les meilleurs délais.');

            $mail = new Email();
            $mail->send('contact@quaiantique.fr', 'Quai antique', 'Vous avez reçu une demande de contact');

        }


        return $this->render('contact/index.html.twig', [
            'form' => $form
        ]);
    }
}
