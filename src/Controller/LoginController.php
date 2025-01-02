<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginController extends AbstractController
{
  private UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  #[Route('/login', name: 'app_login')]
  public function login(AuthenticationUtils $authenticationUtils): Response
  {
    // Récupère l'erreur de la dernière tentative de connexion
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    // Vérifie si l'email existe
    if ($lastUsername && !$this->userRepository->findOneBy(['email' => $lastUsername])) {
      $error = new CustomUserMessageAuthenticationException('Adresse email invalide.');
    }

    return $this->render('security/login.html.twig', [
      'last_username' => $lastUsername,
      'error' => $error,
    ]);
  }

  #[Route('/logout', name: 'app_logout')]
  public function logout(): void
  {
    // La déconnexion est gérée automatiquement par Symfony
    throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall.');
  }
}
