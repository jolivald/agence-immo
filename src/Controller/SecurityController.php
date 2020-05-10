<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {

  /**
   * @Route("/login", name="login")
   */
  public function login(AuthenticationUtils $authUtils)
  {
    $lastUsername = $authUtils->getLastUsername();
    $error = $authUtils->getLastAuthenticationError();
    return $this->render('security/login.html.twig', [
      'current_menu' => 'login',
      'last_username' => $lastUsername,
      'error' => $error
    ]);
  }

}