<?php

namespace App\Features\Users\CommandHandler;

use App\Features\Users\Command\ResetPasswordCommand;
use App\Repository\Identities\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

#[AsMessageHandler]
readonly class ResetPasswordCommandHandler
{
    public function __construct(private UserPasswordHasherInterface $hasher, private UserRepository $userRepository)
    {
    }

    public function __invoke(ResetPasswordCommand $command): void
    {
        $user = $this->userRepository->findOneByEmail($command->getEmail());
        if (!$user) {
            throw new UserNotFoundException();
        }
        $user->setPassword($this->hasher->hashPassword($user, $command->getPassword()));
        $this->userRepository->save($user);
    }
}