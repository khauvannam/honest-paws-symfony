<?php

namespace App\Features\Users\CommandHandler;


use App\Entity\Users\CaseDescription;
use App\Features\Tokens\Command\CreateTokenCommand;
use App\Features\Users\Command\ResetPasswordRequestCommand;
use App\Repository\Identities\TokenRepository;
use App\Repository\Identities\UserRepository;
use App\Services\MailerService;
use Exception;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsMessageHandler]
class ResetPasswordRequestHandler
{
    private UserRepository $userRepository;
    private TokenRepository $tokenRepository;
    private MailerService $MailerService;

    public function __construct(UserRepository $userRepository, TokenRepository $tokenRepository, MailerService $MailerService)
    {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
        $this->MailerService = $MailerService;
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function __invoke(ResetPasswordRequestCommand $command): void
    {
        $email = $command->getEmail();

        // Check if the user exists
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
           
            throw new Exception("User not found.");
        }

        // Create a new token for resetting the password
        $caseDescription = CaseDescription::ResetPassword;
        $createTokenCommand = new CreateTokenCommand($email, $caseDescription);
        $newTokenEntity = $this->tokenRepository->createToken($createTokenCommand);

        // Save the new token (or do something with it, like sending it via email)
        $this->tokenRepository->save($newTokenEntity);

        $this->MailerService->sendResetPasswordEmail($email, $newTokenEntity->getToken());
    }

}
