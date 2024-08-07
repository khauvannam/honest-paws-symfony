<?php

namespace App\Controller\TestMail;

use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestMail extends AbstractController
{
    private MailerService $mailerService;
    private MessageBusInterface $bus;

    public function __construct(MailerService $mailerService, MessageBusInterface $bus)
    {
        $this->mailerService = $mailerService;
        $this->bus = $bus;
    }

    #[Route('/mail', name: 'mail', methods: ['GET'])]
    public function index(): Response
    {
        $to = 'chungthanhnguyen277@gmail.com';
        $username = 'TestUser';

        try {
            $this->mailerService->sendRegistrationEmail($to, $username);
            $message = 'Test email has been sent.';
        } catch (\Exception $e) {
            $message = 'Failed to send test email: ' . $e->getMessage();
        } catch (TransportExceptionInterface $e) {
            $message = 'Failed to send test email: ' . $e->getMessage();
        }

        return new Response($message);
    }

    #[Route('/test_dutch', name: 'dutch', methods: ['GET'])]
    public function dutch()
    {
        return $this->render('security/insert-email.html.twig');
    }

}
