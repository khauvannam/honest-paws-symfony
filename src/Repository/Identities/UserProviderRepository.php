<?php

namespace App\Repository\Identities;

use App\Entity\Users\UserProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProvider|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProvider|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProvider[] findAll()
 * @method UserProvider[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProviderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, UserProvider::class);
    }

    public function save($userProvider): void
    {
        $this->entityManager->persist($userProvider);
        $this->entityManager->flush();
    }

    public function remove($userProvider): void
    {
        $this->entityManager->remove($userProvider);
        $this->entityManager->flush();
    }
   
}
