<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerService
{
    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendRegistrationEmail(string $to, string $username): void
    {
        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($to)
            ->subject('Registration Successful')
            ->html($this->twig->render('emails/mailer.html.twig', [
                'username' => $username,
            ]));

        $this->mailer->send($email);
    }
}
