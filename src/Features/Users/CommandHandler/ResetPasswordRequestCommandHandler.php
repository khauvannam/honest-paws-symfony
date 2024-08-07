<?php
// src/Features/Users/Command/ResetPasswordRequestCommandHandler.php

namespace App\Features\Users\CommandHandler;

use App\Entity\Users\CaseDescription;
use App\Features\Users\Command\ResetPasswordRequestCommand;
use App\Repository\Identities\UserProviderRepository;
use App\Repository\Identities\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

#[AsMessageHandler]
class ResetPasswordRequestCommandHandler
{
    private UserRepository $userRepository;
    private TokenGeneratorInterface $tokenGenerator;
    private UserProviderRepository $userProviderRepository;
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserProviderRepository $userProviderRepository,
        TokenGeneratorInterface $tokenGenerator,
        MailerInterface $mailer,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->userProviderRepository = $userProviderRepository;
    }

    public function __invoke(ResetPasswordRequestCommand $command)
    {
        $email = $command->getEmail();
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user) {
            throw new \Exception('User not found.');
        }

        $token = $this->tokenGenerator->generateToken();
        $this->userProviderRepository->setToken($token);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $emailMessage = (new Email())
            ->from('noreply@example.com')
            ->to($email)
            ->subject('Password Reset Request')
            ->html(sprintf('Your password reset token is: %s', $token));

        $this->mailer->send($emailMessage);
    }
}
