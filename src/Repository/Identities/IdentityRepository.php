<?php

namespace App\Repository\Identities;

use App\Entity\Users\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class IdentityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
    }

    public function createAsync(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(["email" => $email]);
    }
    public function update(User $user): User
    {
        $this->entityManager->flush();
        return $user;
    }
}
