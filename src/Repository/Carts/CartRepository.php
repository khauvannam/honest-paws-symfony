<?php

namespace App\Repository\Products\Carts;

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

    public function remove(Cart $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    public function findById(string $id): ?Cart
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function update(Cart $cart): Cart
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($cart);
        $entityManager->flush();
        return $cart;
    }
}
