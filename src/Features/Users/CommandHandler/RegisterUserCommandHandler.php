<?php

namespace App\Features\Users\CommandHandler;

use App\Entity\Users\User;
use App\Features\Users\Command\RegisterUserCommand;
use App\Repository\Identities\IdentityRepository;
use App\Services\MailerService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsMessageHandler]
class RegisterUserCommandHandler
{
    private IdentityRepository $identityRepository;
    private UserPasswordHasherInterface $userPasswordHasher;
    private MailerService $mailSuccess;
    public function __construct(
        IdentityRepository $identityRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        MailerService $mailSuccess
    ) {
        $this->identityRepository = $identityRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->mailSuccess = $mailSuccess;
    }


    public function __invoke(RegisterUserCommand $command): void
    {
        $plainTextPassword = $command->getPassword();
        $user = User::Create($command->getUsername(), $command->getEmail());
        $hashPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $plainTextPassword
        );
        $user->setPassword($hashPassword);
        $this->mailSuccess->sendRegistrationEmail($user->getEmail(), $user->getUsername());
        $this->identityRepository->createAsync($user);
    }
}
