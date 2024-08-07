<?php

namespace App\Repository\Identities;

use App\Entity\Users\UserProvider;
use Doctrine\ORM\EntityManagerInterface;
use App\Features\Tokens\Command\CreateTokenCommand;

class TokenRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByToken(string $token): ?UserProvider
    {
        return $this->entityManager->getRepository(UserProvider::class)
            ->findOneBy(['token' => $token]);
    }

    public function createToken(CreateTokenCommand $command): UserProvider
    {
        $userProvider = UserProvider::create(
            $command->getEmail(),
            $command->getCaseDescription(),
            bin2hex(random_bytes(16)) // Generate a random token
        );

        $this->entityManager->persist($userProvider);
        $this->entityManager->flush();

        return $userProvider;
    }

    public function save(UserProvider $userProvider): void
    {
        $this->entityManager->persist($userProvider);
        $this->entityManager->flush();
    }

    public function delete(UserProvider $userProvider): void
    {
        $this->entityManager->remove($userProvider);
        $this->entityManager->flush();
    }
}
