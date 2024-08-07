<?php

namespace App\Features\Users\CommandHandler;

use App\Features\Users\Command\ChangePasswordCommand;
use App\Repository\Identities\IdentityRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class ChangePasswordCommandHandler
{
    public function __construct(private IdentityRepository $identityRepository, private UserPasswordHasherInterface $hasher)
    {
    }


    public function __invoke(ChangePasswordCommand $command): void
    {
        $user = $this->identityRepository->findOneBy(['id' => $command->getUserId()]);
        $validPassword = $this->hasher->isPasswordValid($user, $command->getPassword());
        if (!$validPassword) {
            throw new InvalidPasswordException();
        }
        $newHasherPassword = $this->hasher->hashPassword($user, $command->getNewPassword());
        $user->setPassword($newHasherPassword);
        $this->identityRepository->update($user);

    }

}