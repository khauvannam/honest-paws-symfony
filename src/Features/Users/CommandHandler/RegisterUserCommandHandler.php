<?php

namespace App\Features\Users\CommandHandler;

use App\Entity\Users\User;
use App\Features\Users\Type\RegisterUserCommand;
use App\Repository\Identities\IdentityRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class RegisterUserCommandHandler
{
    private IdentityRepository $identityRepository;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        IdentityRepository $identityRepository,
        UserPasswordHasherInterface $userPasswordHasher
    ) {
        $this->identityRepository = $identityRepository;
        $this->userPasswordHasher = $userPasswordHasher;
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
        $this->identityRepository->createAsync($user);
    }
}
