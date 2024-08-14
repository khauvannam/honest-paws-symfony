<?php

namespace App\Repository\Orders;

use App\Entity\Orders\OrderBase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderBase::class);
    }

    public function update(): void
    {
        $em = $this->getEntityManager();
        $em->flush();
    }

    public function save(OrderBase $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }

    /**
     * Get all orders ordered by order date in descending order.
     *
     * @return OrderBase[]
     */
    public function getOrdersByOrderDateDesc(): array
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.orderDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get orders by customer ID.
     *
     * @param string $customerId
     * @return OrderBase[]
     */
    public function getOrdersByCustomerId(string $customerId): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.customerId = :customerId')
            ->setParameter('customerId', $customerId)
            ->getQuery()
            ->getResult();
    }

    public function findOrdersWithPagination(int $limit, int $offset)
    {
        return $this->createQueryBuilder('o')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('o.orderDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllOrders()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.orderDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function countOrders()
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
