<?php

namespace App\Features\Orders\QueryHandler;

use App\Features\Orders\Query\GetOrdersByCustomerId;
use App\Repository\Orders\OrderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetOrdersByCustomerIdHandler
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {
    }

    public function __invoke(GetOrdersByCustomerId $query): array
    {
        return $this->orderRepository->getOrdersByCustomerId($query->getCustomerId());
    }
}
