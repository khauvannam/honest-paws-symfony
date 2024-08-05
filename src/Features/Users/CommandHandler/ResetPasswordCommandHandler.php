<?php

namespace App\Features\Users\CommandHandler;

use App\Features\Users\Command\ResetPasswordCommand;
use App\Repository\Identities\IdentityRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

#[AsMessageHandler]
class ResetPasswordCommandHandler
{

    public function __construct(private IdentityRepository $identityRepository, private UserPasswordHasherInterface $hasher)
    {
    }

    public function __invoke(ResetPasswordCommand $command): void
    {
        $user = $this->identityRepository->findOneBy(['id' => $command->getUserId()]);
        if (!$user) {
            throw new UserNotFoundException();
        }
        $hashPassword = $this->hasher->hashPassword($user, $command->getPassword());
        $user->setPassword($hashPassword);
        $this->identityRepository->update($user);
    }

}