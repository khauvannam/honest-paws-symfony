<?php

namespace App\Repository\Orders;

use App\Entity\Orders\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $order, bool $flush = true): void
    {
        $this->_em->persist($order);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Order $order, bool $flush = true): void
    {
        $this->_em->remove($order);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByUserId(string $userId): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function findByStatus(int $status): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.orderStatus = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
    }

    public function findOrderWithLines(string $orderId): ?Order
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.orderLines', 'ol')
            ->addSelect('ol')
            ->where('o.id = :id')
            ->setParameter('id', $orderId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
