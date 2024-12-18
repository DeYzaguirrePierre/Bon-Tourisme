<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']); // Par défaut, utilisateur non admin
            $user->setVerified(false);

            // Génération du token de confirmation
            $user->setConfirmationToken(Uuid::v4());

            // Persist l'utilisateur
            $entityManager->persist($user);
            $entityManager->flush();

            // Envoie l'email de confirmation avec le lien contenant le token
            $email = (new TemplatedEmail())
                ->from('no-reply@votre-site.com')
                ->to($user->getEmail())
                ->subject('Confirmez votre compte')
                ->htmlTemplate('emails/confirmation_email.html.twig')
                ->context([
                    'user' => $user, // Ajoute l'utilisateur au contexte
                    'confirmationToken' => $user->getConfirmationToken(),
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Un email de confirmation a été envoyé. Veuillez vérifier votre boîte mail.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/confirm-account/{token}', name: 'app_confirm_account')]
    public function confirmAccount(
        string $token,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $entityManager->getRepository(User::class)->findOneBy(['confirmationToken' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Token invalide ou utilisateur introuvable.');
            return $this->redirectToRoute('app_home');
        }

        // Valide le compte
        $user->setVerified(true);
        $user->setConfirmationToken(null); // Supprime le token
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte a été confirmé avec succès ! Vous pouvez maintenant vous connecter.');

        return $this->redirectToRoute('app_login');
    }
}
