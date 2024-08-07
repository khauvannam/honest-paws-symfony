<?php

namespace App\Features\Users\CommandHandler;

use App\Entity\Users\UserProvider;
use App\Features\Users\Command\ResetPasswordCommand;
use App\Repository\Identities\IdentityRepository;
use App\Repository\Identities\UserProviderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

#[AsMessageHandler]
class ResetPasswordCommandHandler
{
    public function __construct(
        private UserProviderRepository $userProviderRepository,
        private IdentityRepository $identityRepository
    ) {
    }

    public function __invoke(ResetPasswordCommand $command): void
    {
        $user = $this->identityRepository->findOneByEmail($command->getEmail());
        if (!$user) {
            throw new UserNotFoundException();
        }

        $userToken = $this->userProviderRepository->findOneBy([
            'email' => $command->getEmail(),
            'token' => $command->getToken(),
            'caseDescription' => 'Reset Password'
        ]);

        if (!$userToken) {
            throw new BadCredentialsException('Invalid token.');
        }

        // Assuming you have a method to update the password
        $user->setPassword($command->getNewPassword());
        $this->identityRepository->save($user);

        // Optionally remove the token after successful password reset
        $this->userProviderRepository->remove($userToken);
    }
}
