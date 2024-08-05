<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Symfony\Component\Routing\RouterInterface;

class MailerService
{
    private MailerInterface $mailer;
    private Environment $twig;
    private RouterInterface $router;

    public function __construct(MailerInterface $mailer, Environment $twig, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->router = $router;
    }

    public function sendRegistrationEmail(string $to, string $username): void
    {
        // Generate the URL for login page
        $loginUrl = $this->router->generate('login', [], RouterInterface::ABSOLUTE_URL);

        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($to)
            ->subject('Registration Successful')
            ->html($this->twig->render('emails/mailer.html.twig', [
                'username' => $username,
                'loginUrl' => $loginUrl,
            ]));

        $this->mailer->send($email);
    }
}
