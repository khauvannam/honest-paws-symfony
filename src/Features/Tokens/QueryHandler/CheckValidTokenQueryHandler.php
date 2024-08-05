<?php

namespace App\Features\Tokens\QueryHandler;

use App\Features\Tokens\Query\CheckValidTokenQuery;
use App\Repository\Identities\UserProviderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CheckValidTokenQueryHandler
{

    public function __construct(private readonly UserProviderRepository $userProviderRepository)
    {
    }

    public function __invoke(CheckValidTokenQuery $query): bool
    {
        $existingToken = $this->userProviderRepository->findOneBy(['userId' => $query->getUserId(), 'token' => $query->getToken(), 'caseDescription' => $query->getCaseDescription()]);
        if (!$existingToken || $existingToken->getCreatedAt() < new \DateTime('-5 minutes')) return false;
        return true;
    }

}