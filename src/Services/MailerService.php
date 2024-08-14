<?php


namespace App\Services;

use App\Entity\Orders\OrderBase;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendRegistrationEmail(string $to, string $username, string $userId): void
    {

        $email = (new Email())
            ->from('singaporestore220803@gmail.com')
            ->to($to)
            ->subject('Registration Successful')
            ->html($this->twig->render('emails/verify-user.html.twig', [
                'username' => $username,
                'userId' => $userId
            ]));

        $this->mailer->send($email);
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendOrderConfirmationEmail(string $to, OrderBase $order): void
    {
        $email = (new Email())
            ->from('singaporestore220803@gmail.com')
            ->to($to)
            ->subject('Order Confirmation')
            ->html($this->twig->render('security/order_success.html.twig', [
                'order' => $order
            ]));

        $this->mailer->send($email);
    }
}
