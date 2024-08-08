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

    #[Route('/test_dutch', name: 'dutch', methods: ['GET'])]
    public function dutch()
    {
        return $this->render('security/insert-email.html.twig');
    }
}
