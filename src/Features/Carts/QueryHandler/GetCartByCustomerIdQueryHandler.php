<?php

namespace App\Features\Carts\QueryHandler;

use App\Entity\Carts\Cart;
use App\Features\Carts\Query\GetCartByCustomerId;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetCartByCustomerIdQueryHandler
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(GetCartByCustomerId $query): ?Cart
    {
        
        return $this->cartRepository->findOneBy(['customerId' => $query->getCustomerId()]);
    }
}
