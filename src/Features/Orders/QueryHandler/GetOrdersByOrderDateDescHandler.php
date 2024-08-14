<?php

namespace App\Features\Orders\QueryHandler;

use App\Features\Orders\Query\GetOrdersByOrderDateDesc;
use App\Repository\Orders\OrderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetOrdersByOrderDateDescHandler
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    public function __invoke(GetOrdersByOrderDateDesc $query): array
    {
        return $this->orderRepository->getOrdersByOrderDateDesc();
    }
}
