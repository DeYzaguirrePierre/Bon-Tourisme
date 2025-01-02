<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ForgotPasswordController extends AbstractController
{
  #[Route('/forgot-password', name: 'app_forgot_password')]
  public function forgotPassword(
    Request $request,
    EntityManagerInterface $entityManager,
    MailerInterface $mailer,
    TokenGeneratorInterface $tokenGenerator
  ): Response {
    if ($request->isMethod('POST')) {
      $email = $request->request->get('email');
      $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

      if ($user) {
        // Génération d'un token de réinitialisation
        $resetToken = $tokenGenerator->generateToken();
        $user->setResetToken($resetToken);
        $entityManager->flush();

        // Envoi de l'email
        $email = (new Email())
          ->from('no-reply@bon-tourisme.com')
          ->to($user->getEmail())
          ->subject('Réinitialisation de votre mot de passe')
          ->html($this->renderView('emails/reset_password.html.twig', [
            'user' => $user,
            'resetToken' => $resetToken,
          ]));

        $mailer->send($email);

        $this->addFlash('success', 'Un email de réinitialisation a été envoyé.');
      } else {
        $this->addFlash('danger', 'Aucun utilisateur trouvé avec cet email.');
      }

      return $this->redirectToRoute('app_forgot_password');
    }

    return $this->render('security/forgot_password.html.twig');
  }

  #[Route('/reset-password/{token}', name: 'app_reset_password')]
  public function resetPassword(
    string $token,
    Request $request,
    EntityManagerInterface $entityManager,
    UserPasswordHasherInterface $passwordHasher
  ): Response {
    $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken' => $token]);

    if (!$user) {
      $this->addFlash('danger', 'Lien de réinitialisation invalide ou expiré.');
      return $this->redirectToRoute('app_forgot_password');
    }

    if ($request->isMethod('POST')) {
      $newPassword = $request->request->get('password');
      $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
      $user->setPassword($hashedPassword);
      $user->setResetToken(null); // Supprimer le token après usage
      $entityManager->flush();

      $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
      return $this->redirectToRoute('app_login');
    }

    return $this->render('security/reset_password.html.twig', [
      'token' => $token,
    ]);
  }
}
