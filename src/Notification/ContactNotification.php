<?php

namespace App\Notification;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class ContactNotification {

  /**
   * @var MailerInterface
   */
  private $mailer;

  /**
   * @var Environment
   */
  private $renderer;

  public function __construct(MailerInterface $mailer, Environment $renderer)
  {
    $this->mailer = $mailer;
    $this->renderer = $renderer;
  }

  public function notify(Contact $contact)
  {
    $property = $contact->getProperty();
    $email = new TemplatedEmail();
    $email
      ->subject('Agence : '.$property->getTitle())
      ->from('noreplay@agence.fr')
      ->to('contact@agence.fr')
      ->replyTo($contact->getEmail())
      ->htmlTemplate('emails/contact.html.twig')
      ->context([
        'contact' => $contact
      ])
    ;
    $this->mailer->send($email);
  }

}