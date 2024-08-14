<?php

namespace App\Services;

use App\Entity\Users\UserProvider;
use App\Repository\Identities\IdentityRepository;
use App\Repository\Identities\UserProviderRepository;
use DateTime;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Uid\Uuid;

class TokenService
{
    public function __construct(private UserProviderRepository $userProviderRepository, private IdentityRepository $identityRepository)
    {
    }

    public function createToken(mixed $command): void
    {
        $user = $this->identityRepository->findOneByEmail($command->getEmail());
        if (!$user) {
            throw new UserNotFoundException();
        }
        $checkToken = $this->userProviderRepository->findOneBy(['userId' => $user->getId()]);
        if ($checkToken) {
            $this->userProviderRepository->remove($checkToken);
        }
        $userToken = UserProvider::create($user->getId(), $command->getCaseDescription(), substr(Uuid::v4()->toString(), 0, 5));
        $this->userProviderRepository->save($userToken);
    }

    public function checkValidToken(mixed $query): bool
    {
        $user = $this->identityRepository->findOneByEmail($query->getEmail());
        if (!$user) {
            throw new UserNotFoundException();
        }
        $userId = $user->getId();

        $existingToken = $this->userProviderRepository->findOneBy(['userId' => $userId, 'token' => $query->getToken(), 'caseDescription' => $query->getCaseDescription()]);
        if (!$existingToken || $existingToken->getCreatedAt() < new DateTime('-5 minutes')) return false;
        return true;
    }
}