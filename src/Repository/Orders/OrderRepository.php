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

    public function save(OrderBase $order): void
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }
}
