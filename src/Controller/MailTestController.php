<?php

// src/Controller/MailTestController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailTestController extends AbstractController
{
    #[Route('/test-email', name: 'app_test_email')]
    public function sendTestEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('test@example.com')
            ->to('recipient@example.com')
            ->subject('Test MailHog Symfony')
            ->text('Ceci est un e-mail de test envoyé via MailHog.');

        $mailer->send($email);

        return new Response('E-mail envoyé avec succès !');
    }
}
