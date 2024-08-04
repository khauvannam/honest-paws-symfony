<?php

namespace App\Repository\Orders;

use App\Entity\Orders\OrderLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderLine::class);
    }

    public function save(OrderLine $orderLine, bool $flush = true): void
    {
        $this->_em->persist($orderLine);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(OrderLine $orderLine, bool $flush = true): void
    {
        $this->_em->remove($orderLine);

        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByOrderId(int $orderId): array
    {
        return $this->createQueryBuilder('ol')
            ->where('ol.order = :orderId')
            ->setParameter('orderId', $orderId)
            ->getQuery()
            ->getResult();
    }

    public function findByProductId(string $productId): array
    {
        return $this->createQueryBuilder('ol')
            ->where('ol.productId = :productId')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getResult();
    }
}
