<?php

namespace App\Features\Users\CommandHandler;

use App\Entity\Users\UserVerify;
use App\Features\Users\Command\VerifyUserCommand;
use App\Repository\Identities\IdentityRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

#[AsMessageHandler]
class VerifyUserCommandHandler
{
    public function __construct(private readonly IdentityRepository $repository)
    {
    }

    public function __invoke(VerifyUserCommand $command): void
    {
        $user = $this->repository->findOneBy(['id' => $command->getUserId()]);
        if ($user) {
            throw new UserNotFoundException();
        }
        if (!$user->isVerified()) {
            $user->setVerified(UserVerify::verify);
        }

    }
}