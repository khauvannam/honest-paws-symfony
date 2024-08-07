<?php

namespace App\Repository\Identities;

use App\Entity\Users\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $entityManager;
    }

    /**
     * Save a new user or update an existing one.
     */
    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Find a user by their email address.
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * Update an existing user.
     */
    public function update(User $user): User
    {
        $this->entityManager->flush();
        return $user;
    }

    /**
     * Find a user by their ID.
     */
    public function findById(string $id): ?User
    {
        return $this->find($id);
    }

    /**
     * Find a user by their username.
     */
    public function findByUsername(string $username): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
