<?php

namespace App\Features\Users\Handler;

use App\Entity\Users\User;
use App\Features\Users\Command\RegisterUserCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Identities\IdentityRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserCommandHandler implements CommandHandlerInterface
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
