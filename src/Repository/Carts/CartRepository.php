<?php

namespace App\Repository\Carts;

use App\Entity\Carts\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $entity): void
    {
        $this->getEntityManager()->persist($entity);


        $this->getEntityManager()->flush();
    }

    public function update(Cart $entity): Cart
    {
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function remove(Cart $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    public function findByIdAndCustomerId(string $id, string $customerId): ?Cart
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :id')
            ->andWhere('c.customerId = :customerId')
            ->setParameter('id', $id)
            ->setParameter('customerId', $customerId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
