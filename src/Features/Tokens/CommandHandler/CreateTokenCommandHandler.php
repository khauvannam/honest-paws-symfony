<?php

namespace App\Features\Tokens\CommandHandler;

use App\Entity\Users\UserProvider;
use App\Features\Tokens\Command\CreateTokenCommand;
use App\Repository\Identities\IdentityRepository;
use App\Repository\Identities\UserProviderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
class CreateTokenCommandHandler
{

    public function __construct(private UserProviderRepository $userProviderRepository, private IdentityRepository $identityRepository)
    {
    }

    public function __invoke(CreateTokenCommand $command): void
    {
        $user = $this->identityRepository->findOneByEmail($command->getEmail());
        if (!$user) {
            throw new UserNotFoundException();
        }
        $checkToken = $this->userProviderRepository->findOneBy(['email' => $command->getEmail()]);
        if ($checkToken) {
            $this->userProviderRepository->remove($checkToken);
        }
        $userToken = UserProvider::create($user->getId(), $command->getCaseDescription(), substr(Uuid::v4()->toString(), 0, 5));
        $this->userProviderRepository->save($userToken);


    }
}